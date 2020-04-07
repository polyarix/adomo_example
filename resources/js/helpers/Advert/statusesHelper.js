const STATUS_ACTIVE = 'active';
const STATUS_EXPIRED = 'expired';
const STATUS_CLOSED = 'closed';
const STATUS_WORKING = 'working';
const STATUS_MODERATION = 'moderation';
const STATUS_REJECTED = 'rejected';
const STATUS_SPAM = 'spam';
const STATUS_COMPLETED = 'completed'; // turned status to complete and reviews waiting
const STATUS_FINISHED = 'finished'; // finished: reviews were left

export const normalize = (status) => {
    switch (status) {
        case STATUS_WORKING: return 'В работе';
        case STATUS_ACTIVE: return 'В ожидании';
        case STATUS_MODERATION: return 'На модерации';
        case STATUS_REJECTED: return 'Отклонено';
        case STATUS_SPAM: return 'Отклонено за спам';
        case STATUS_COMPLETED: return 'Выполнено';
        case STATUS_FINISHED: return 'Выполнено';
        case STATUS_EXPIRED: return 'Истёк срок действия';
        case STATUS_CLOSED: return 'Закрыт';
    }

    return 'undefined status';
};
