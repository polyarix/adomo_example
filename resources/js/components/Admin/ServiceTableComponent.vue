<template>
    <div class="form-group col-xs-12">
        <table class="table table-bordered table-striped m-b-0">
            <thead>
            <tr>
                <th v-for="column in columns">{{ column }}</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="(item, index) in itemList" :key="index">
                <td>
                    <div class="form-group">
                        <select :name="`${itemName}[${index}][service_id]`" class="form-control"
                                v-model="item.service_id"
                                @change="isServiceAlreadySelected(item.service_id, index)">
                            <option v-for="service in allServices" value="service_id"
                                    :value="service.id">
                                {{ service.name }}
                            </option>
                        </select>
                    </div>
                </td>

                <td>
                    <div class="form-group">
                        <input type="radio" value="1" v-model="item.duration_type"
                               :name="`${itemName}[${index}][duration_type]`"> по количеству
                        <input type="radio" value="0" v-model="item.duration_type"
                               :name="`${itemName}[${index}][duration_type]`"> по дням
                    </div>
                </td>

                <td>
                    <div class="form-group">
                        <input type="number" v-model="item.duration_value"
                               :name="`${itemName}[${index}][duration_value]`">
                    </div>
                </td>

                <td>
                    <button class="btn btn-sm btn-danger" type="button" @click="removeItem(index);">
                        <span class="sr-only">удалить строку</span>
                        <i class="fa fa-trash" role="presentation" aria-hidden="true"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="array-controls btn-group m-t-10">
            <button class="btn btn-sm btn-primary" type="button"
                    @click="addItem()" id="addItemButton" :disabled="buttonDisabled">
                <i class="fa fa-plus"></i> Добавить услугу
            </button>
        </div>
    </div>
</template>

<script>
  export default {
    props: {
      items: {
        type: Array,
        default: () => ['-'],
      },
      allServices: {
        Array,
      },
      columns: {
        type: Array,
        default: () => ['Услуга', 'Как действует', 'Сколько действует', 'Удалить'],
      },
      itemName: {
        type: String,
      },
    },

    data() {
      return {
        itemList: this.items,
        buttonDisabled: false,
      };
    },

    methods: {
      removeItem(i) {
        this.$delete(this.itemList, i);
      },

      addItem() {
        this.itemList.push({
          'allServices': this.allServices,
          'duration_type': 0,
          'duration_value': 0,
          'service': {
            'name': '-',
          },
        });
      },

      isServiceAlreadySelected(service_id) {
        const test = this.itemList.filter((element) => {
          return element.service_id === service_id;
        });

        if (test.length > 1) {
          new PNotify({
            title: 'Ошибка!',
            text: 'Вы пытаетесь добавить уже добавленную услугу!',
            type: 'error',
          });

          this.buttonDisabled = true;
          return;
        }

        this.buttonDisabled = false;
      },
    },
  };
</script>
