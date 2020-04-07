<?php

namespace App\Console\Commands\Common;

use App\Entity\Advert\Advert\Photo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Entity\User\Portfolio;
use Storage;

class GhostImagesCleaner extends Command
{
    protected $signature = 'images:clear';
    protected $description = 'Command for cleaning all uploaded, but not user images.';

    public function handle()
    {
        $storage = Storage::disk('public');

        $removable = ['path', 'crop'];

        foreach (Photo::whereNull('morph_id')->where('created_at', '<=', Carbon::now()->subHours(2))->cursor() as $photo) {
            array_map(function($field) use($storage, $photo) {
                if($storage->exists($photo->{$field})) {
                    $this->info("File {$photo->{$field}} by field {$field} is deleted.");
                    $storage->delete($photo->{$field});
                } else {
                    $this->warn("File {$photo->$field} by field {$field} is'nt exists.");
                }
            }, $removable);

            $photo->delete();
        }

        foreach (Portfolio\Photo::whereNull('album_id')->where('created_at', '<=', Carbon::now()->subHours(2))->get() as $photo) {
            array_map(function($field) use($storage, $photo) {
                if($storage->exists($photo->{$field})) {
                    $this->info("File {$photo->{$field}} by field {$field} is deleted.");
                    $storage->delete($photo->{$field});
                } else {
                    $this->warn("File {$photo->$field} by field {$field} is'nt exists.");
                }
            }, $removable);

            $photo->delete();
        }
    }
}
