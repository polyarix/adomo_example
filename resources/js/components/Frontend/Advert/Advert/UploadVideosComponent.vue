<template>
    <div class="task-form-wrap">
        <div class="task-photo-component">
            <div class="label">Добавьте видео</div>
        </div>

        <div class="modal modal-take-task" style="display: none; max-width: 700px" id="take-task-modal">
            <div class="modal-title">Хотите добавить видео?</div>
            <div class="modal-info-box" v-if="videoUploaded">
                <p><youtube player-width="610" :video-id="videoId" ready="onReady" /></p>
            </div>

            <form onsubmit="return false">
                <div class="form-group">
                    <label for="messsage">Вставьте ссылку на видео из YouTube</label>
                    <input type="text" id="messsage" v-model="url">
                </div>

                <div class="modal-footer" v-if="actionsEnabled">
                    <button class="btn btn-small btn-grey" @click="onCancel">Отмена  </button>
                    <button class="btn btn-small btn-yellow" @click="onSubmit">Добавить  </button>
                </div>
            </form>
        </div>

        <div class="modal modal-take-task" style="display: none; max-width: 700px" id="edit-video-modal">
            <div class="modal-title">Хотите отредактировать видео?</div>
            <div class="modal-info-box" v-if="videoUploaded">
                <p><youtube player-width="610" :video-id="videoId" ready="onReady" /></p>
            </div>

            <form onsubmit="return false">
                <div class="form-group">
                    <label for="messsage">Вставьте ссылку на видео из YouTube</label>
                    <input type="text" id="messsage" v-model="url">
                </div>

                <div class="modal-footer" v-if="actionsEnabled">
                    <button class="btn btn-small btn-dark" @click="onRemove">Удалить  </button>
                    <button class="btn btn-small btn-grey" @click="onCancel">Отмена  </button>
                    <button class="btn btn-small btn-yellow" @click="onUpdate">Изменить  </button>
                </div>
            </form>
        </div>

        <div class="vux-uploader">
            <div class="vux-uploader_bd">
                <ul class="vux-uploader_files">
                    <li
                        class="vux-uploader_file vux-uploader_file-status"
                        v-for="(video, index) in videos"
                        :title="video"
                        @click="showVideoEditPage(index)"
                        :style="{'background-image': 'url(https://img.youtube.com/vi/' + video +'/mqdefault.jpg)', 'background-size': 'cover'}"
                    >
                    </li>
                </ul>
                <div class="vux-uploader_input-box">
                    <div class="vux-uploader_input-box-icon" style="background-image:url(/images/add-file-icon.svg)"></div>
                    <div class="vux-uploader_input" @click="onPopupShow"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            initVideos: {
                type: Array,
                default: () => []
            }
        },

        data() {
            return {
                url: '',
                videos: this.initVideos,
                index: null
            }
        },

        computed: {
            actionsEnabled() {
                return this.url.length > 0
            },
            videoId() {
                return this.$youtube.getIdFromURL(this.url)
            },
            videoUploaded() {
                return this.videoId && this.videoId.length > 0
            }
        },

        methods: {
            showVideoEditPage(index) {
                let video = this.videos[index];

                this.url = video;
                this.index = index;
                this.showEditPopup();
            },
            onRemove() {
                this.$delete(this.videos, this.index);

                this.url = '';
                this.index = null;

                this.$emit('change', this.videos);
                this.hideEditPopup();
            },
            onUpdate() {
                this.$set(this.videos, this.index, this.videoId)

                this.url = '';
                this.index = null;

                this.$emit('change', this.videos);
                this.hideEditPopup();
            },
            onPopupShow() {
                $.fancybox.open( $('#take-task-modal'))
            },
            showEditPopup() {
                $.fancybox.open( $('#edit-video-modal'))
            },
            hideEditPopup() {
                $.fancybox.close( $('#edit-video-modal'))
            },
            onCancel() {
                this.url = '';
                $.fancybox.close( $('#take-task-modal'))
            },
            onSubmit() {
                this.videos.push(this.videoId);
                this.$emit('change', this.videos);
                this.url = '';
                $.fancybox.close( $('#take-task-modal'))
            },
            onReady(e) {
                console.log(e)
            }
        }
    }
</script>

<style scoped>
    .vux-uploader_input-box-icon:hover {
        cursor: pointer;
    }
</style>
