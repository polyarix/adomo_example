<?php

namespace App\UseCase\User\Conversation;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\Conversation\Attachment;
use App\Entity\User\Conversation\Conversation;
use App\Entity\User\User;
use Illuminate\Http\UploadedFile;

class ConversationService
{
    public function findForOrder(Order $order): ?Conversation
    {
        return Conversation::where('order_id', $order->id)->first();
    }

    public function uploadAttachment(User $user, UploadedFile $file): Attachment
    {
        $name = uniqid() . '.' . $file->extension();
        $file->storeAs(Attachment::STORAGE_DIR, "{$name}");

        $attachment = Attachment::create([
            'filename' => $file->getClientOriginalName(),
            'mime' => $file->getMimeType(),
            'path' => Attachment::STORAGE_DIR."/{$name}",
            'user_id' => $user->id,
        ]);

        return $attachment;
    }

    public function viewAttachment(User $user, Attachment $attachment)
    {
        if(\Gate::denies('show_conversation_attachments', $attachment)) {
            throw new \DomainException('You don\'t have permissions to view the file.');
        }

        return response()->download(storage_path('app/' . $attachment->path));
    }
}
