const TYPE_CATEGORY = 'category';
const TYPE_SERVICE = 'service';
const TYPE_ORDER = 'order';

const CATEGORY_ROUTE_NAME = 'category.show';
const ORDER_ROUTE_NAME = 'advert.order.show';
const SERVICE_ROUTE_NAME = 'advert.task.show';

class EntityFactory
{
    static build(data) {
        if(data.type === TYPE_SERVICE) {
            return new ServiceFactory(data)
        }

        if(data.type === TYPE_ORDER) {
            return new OrderFactory(data)
        }

        return new CategoryFactory(data)
    }
}

class AbstractFactory {
    constructor(data) {
        this.data = data;
    }

    isCategory() {
        return this.data.type === TYPE_CATEGORY
    }
    isService() {
        return this.data.type === TYPE_SERVICE
    }
    isOffer() {
        return this.data.type === TYPE_ORDER
    }
}

class CategoryFactory extends AbstractFactory
{
    getUrl() {
        return route(CATEGORY_ROUTE_NAME, this.data.slug)
    }

    getDescription() {
        return this.data.title
    }
}

class OrderFactory extends AbstractFactory
{
    getUrl() {
        return route(ORDER_ROUTE_NAME, this.data.slug)
    }

    getDescription() {
        return `<a :href="route(${ORDER_ROUTE_NAME}, ${this.data.slug})">${this.data.title}</a> в категории <span class="advert-category">${this.data.category}</span>`
    }
}

class ServiceFactory extends AbstractFactory
{
    getUrl() {
        return route(SERVICE_ROUTE_NAME, this.data.slug)
    }

    getDescription() {
        return `<a :href="route(${SERVICE_ROUTE_NAME}, ${this.data.slug})">${this.data.title}</a></span>`
    }
}

export default EntityFactory
