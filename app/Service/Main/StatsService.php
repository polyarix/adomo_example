<?php

namespace App\Service\Main;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\User;

class StatsService
{
    // Посетителей в день
    public function dailyVisitorsCount(): int
    {
        return 1694883;
    }

    // Удачных сделок
    public function successDealsCount(): int
    {
        return Order::whereIn('status', [Order::STATUS_COMPLETED, Order::STATUS_FINISHED])->count();
    }

    // Реальных отзывов
    public function reviewsCount(): int
    {
        return Order\Review::count();
    }

    // Заказчиков
    public function customersCount(): int
    {
        return User::customer()->count();
    }
}
