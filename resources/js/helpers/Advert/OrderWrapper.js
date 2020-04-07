const STATUS_ACTIVE = 'active';
const STATUS_EXPIRED = 'expired';
const STATUS_CLOSED = 'closed';
const STATUS_WORKING = 'working';
const STATUS_MODERATION = 'moderation';
const STATUS_REJECTED = 'rejected';
const STATUS_SPAM = 'spam';
const STATUS_COMPLETED = 'completed'; // turned status to complete and reviews waiting
const STATUS_FINISHED = 'finished'; // finished: reviews were left

export default class orderWrapper {
    constructor(order) {
        this.order = order;
    }

    isOnModeration() {
        return this.order.status === STATUS_MODERATION;
    }
    isActive() {
        return this.order.status === STATUS_ACTIVE;
    }
    isRejected() {
        return this.order.status === STATUS_REJECTED;
    }
    isExpired() {
        return this.order.status === STATUS_EXPIRED;
    }
    isClosed() {
        return this.order.status === STATUS_CLOSED;
    }
    isSpam() {
        return this.order.status === STATUS_SPAM;
    }
    isWorking() {
        return this.order.status === STATUS_WORKING;
    }
    isFinished() {
        return this.order.status === STATUS_FINISHED;
    }
    isCompleted() {
        return this.order.status === STATUS_COMPLETED;
    }
}
