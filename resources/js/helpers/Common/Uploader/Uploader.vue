<template>
    <div :class="{ 'vux-uploader': true, 'vux-uploader-with-title': hasDescription }">
        <div class="vux-uploader_bd">
            <ul class="vux-uploader_files">
                <li
                    :class="{
              'vux-uploader_file': true,
              'vux-uploader_file-status': !!item.fetchStatus && item.fetchStatus !== 'success'
            }"
                    v-for="(item, index) in fileList"
                    :key="index"
                    :style="{
              backgroundImage: `url(${item.url})`
            }"
                    @click="handleFileClick($event, item, index)"
                >
                    <slot name="image-label" :item="item"></slot>

                    <div
                        v-if="!!item.fetchStatus && item.fetchStatus !== 'success'"
                        class="vux-uploader_file-content"
                    >
                        {{ item.fetchStatus === 'progress' ? item.progress + '%' : '' }}
                        <!-- progress !== 0 && progress < 100 -->
                        <i v-if="item.fetchStatus === 'fail'" class="upload-error"></i>
                    </div>
                </li>

                <li class="vux-uploader_file vux-uploader_preloader" v-if="showLoader">
                    <file-upload-loader :mobile="!hasDescription" />
                </li>
            </ul>
            <div class="vux-uploader_input-box" v-show="fileList.length < limit && !readonly">
                <div class="vux-uploader_input-box-icon" style="background-image:url(/images/add-file-icon.svg)"></div>

                <span v-if="hasDescription">{{ description }}</span>

                <input
                    class="vux-uploader_input"
                    ref="input"
                    type="file"
                    name="uploadInput"
                    accept="image/*"
                    :capture="capture"
                    :multiple="multiple"
                    @change="change"
                />
            </div>
        </div>
        <div
            class="vux-uploader_previewer"
            id="previewer"
            v-if="previewVisible"
        >
            <div class="vux-uploader_preview-img" id="previewerImg" @click="hidePreviewer"></div>
            <div class="vux-uploader_del" v-if="!readonly" @click="deleteImg"></div>
        </div>
    </div>
</template>
<script>
    import { handleFile, transformCoordinate, dataURItoBlob } from "./utils";
    import FileUploadLoader from "../../../components/Shared/Loaders/FileUploadLoader";

    // compatibility for window.URL
    const URL =
        window.URL && window.URL.createObjectURL
            ? window.URL
            : window.webkitURL && window.webkitURL.createObjectURL
            ? window.webkitURL
            : null;
    export default {
        name: "Uploader",
        model: {
            prop: "files",
            event: "on-fileList-change"
        },
        props: {
            title: {
                type: String,
                default: "图片上传"
            },
            description: {
                type: String,
                default: null
            },
            files: {
                type: Array,
                default: () => []
            },
            limit: {
                type: Number | String,
                default: 5
            },
            capture: {
                type: Boolean | String,
                default: false
            },
            enableCompress: {
                type: Boolean,
                default: true
            },
            maxWidth: {
                type: String | Number,
                default: 1024
            },
            quality: {
                type: String | Number,
                default: 0.92
            },
            url: {
                type: String
            },
            params: {
                type: Object,
            },
            name: {
                type: String,
                default: 'file',
            },
            autoUpload: {
                type: Boolean,
                default: true
            },
            multiple: {
                type: String | Boolean,
                default: ""
            },
            readonly: {
                type: Boolean,
                default: false,
            },
        },
        computed: {
            hasDescription() {
                return this.description && this.description.length > 0
            },
            showLoader() {
                return this.loaderVisible
            }
        },
        data() {
            return {
                fileList: this.files,
                currentIndex: 0,
                previewVisible: false,
                loaderVisible: false
            };
        },
        watch: {
            files: {
                deep: true,
                handler(files) {
                    this.fileList = files;
                }
            },
            fileList: {
                deep: true,
                handler(fileList) {
                    this.$emit('on-fileList-change', fileList);
                }
            },
        },
        methods: {
            async change(e) {
                const {
                    enableCompress,
                    maxWidth,
                    quality,
                    limit,
                    fileList,
                    autoUpload,
                    uploadFile
                } = this;
                const target = e.target || e.srcElement;
                const inputChangeFiles = target.files;
                if (inputChangeFiles.length > 0) {
                    if (fileList.length + inputChangeFiles.length > limit) {
                        alert(`Лимит файлов ${limit}`);
                        return;
                    }
                    Promise.all(
                        Array.prototype.map.call(inputChangeFiles, file => {
                            return handleFile(file, {
                                maxWidth,
                                quality,
                                enableCompress
                            }).then(blob => {
                                const blobURL = URL.createObjectURL(blob);
                                const fileItem = {
                                    url: blobURL,
                                    blob
                                };
                                for (let key in file) {
                                    if (["slice", "webkitRelativePath"].indexOf(key) === -1) {
                                        fileItem[key] = file[key];
                                    }
                                }
                                if (autoUpload){
                                    this.loaderVisible = true;

                                    uploadFile(blob, fileItem).then((result) => {
                                        const data = result.data;

                                        fileItem.id = data.id;
                                        fileList.push(fileItem);
                                        this.$emit('on-change', fileItem, fileList);
                                    }).catch(e => {
                                        fileList.push(fileItem);
                                    }).finally(() => {
                                        this.loaderVisible = false;
                                    });
                                } else {
                                    fileList.push(fileItem);
                                    this.$emit('on-change', fileItem, fileList);
                                }
                            });
                        })
                    ).then(() => {
                        this.$refs.input.value = "";
                    });
                } else {
                    this.$emit("on-cancel");
                }
            },
            handleFileClick(e, item, index) {
                this.showPreviewer();
                this.$nextTick(() => {
                    const previewerImg = document.getElementById("previewerImg");
                    previewerImg.style.backgroundImage = `url(${item.url})`;
                    this.currentIndex = index;
                })
            },
            showPreviewer() {
                this.previewVisible = true;
            },
            hidePreviewer() {
                this.previewVisible = false;
            },
            deleteImg() {
                const { currentIndex, fileList } = this;
                const delFn = () => {
                    this.hidePreviewer();
                    this.$emit('on-change', fileList[currentIndex], fileList);
                    fileList.splice(currentIndex, 1);
                };
                console.log(this.$listeners);
                if (this.$listeners['on-delete']) {
                    this.$emit("on-delete", delFn);
                } else {
                    delFn();
                }
            },
            uploadFile(blob, fileItem) {
                return new Promise((resolve, reject) => {
                    const me = this;
                    const { url, params, name } = me;
                    me.$set(fileItem, "fetchStatus", "progress");
                    me.$set(fileItem, "progress", 0);
                    const formData = new FormData();
                    formData.append(name, blob);
                    if (params) {
                        for(let key in params) {
                            formData.append(key, params[key]);
                        }
                    }

                    axios.post(url, formData, {
                        headers: {
                            Accept: 'application/json',
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: (evt) => {
                            if (evt.lengthComputable) {
                                const precent = Math.ceil((evt.loaded / evt.total) * 100);
                                me.$set(fileItem, "progress", precent);
                            }
                        },
                    }).then(result => {
                        me.$emit("on-success", result, fileItem);
                        me.$set(fileItem, "fetchStatus", "success");
                        resolve(result);
                    }).catch(err => {
                        if(err.response && err.response.data && err.response.data.errors) {
                            const errors = err.response.data.errors;
                            alert(errors[Object.keys(errors)][0])
                        }

                        me.$emit("on-error", err);
                        me.$set(fileItem, "fetchStatus", "fail");
                        reject(err);
                    });
                });
            }
        },
        components: {
            FileUploadLoader
        }
    };
</script>
<style scoped>
    .vux-uploader-with-title .vux-uploader_input-box {
        width: 110px !important;
        height: 140px !important;
    }
    .vux-uploader-with-title li.vux-uploader_file {
        width: 110px !important;
        height: 140px !important;
        position: relative;
    }
    .vux-uploader-with-title .vux-uploader_input-box-icon {
        top: 40% !important;
        transform: translate(-50%,-40%) !important;
    }

    .vux-uploader .vux-uploader_hd {
        display: flex;
        padding-bottom: 10px
    }

    .vux-uploader .vux-uploader_hd .vux-uploader_title {
        flex: 1
    }

    .vux-uploader .vux-uploader_hd .vux-uploader_info {
        color: #b2b2b2
    }

    .vux-uploader .vux-uploader_bd {
        overflow: hidden;
        margin-left: -9px
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_files {
        list-style: none
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_files .vux-uploader_file {
        float: left;
        margin-left: 9px;
        margin-bottom: 9px;
        width: 79px;
        height: 79px;
        background: center center/cover no-repeat
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_files .vux-uploader_file-status {
        position: relative
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_files .vux-uploader_file-status:before {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.4)
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_files .vux-uploader_file-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        color: #fff
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_files .vux-uploader_file-content .upload-error {
        display: inline-block;
        font-size: 23px;
        color: #f43530;
        font-family: weui;
        font-style: normal
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_files .vux-uploader_file-content .upload-error:before {
        content: "\EA0B"
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_input-box {
        float: left;
        position: relative;
        margin-left: 9px;
        margin-bottom: 9px
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_input-box:after,.vux-uploader .vux-uploader_bd .vux-uploader_input-box:before {
        content: " ";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        background-color: #d9d9d9
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_input-box:before {
        width: 2px;
        height: 39.5px
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_input-box:after {
        width: 39.5px;
        height: 2px
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_input-box .vux-uploader_input {
        position: absolute;
        z-index: 1;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        -webkit-tap-highlight-color: transparent
    }

    .vux-uploader .vux-uploader_previewer {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: #000;
        z-index: 1000
    }

    .vux-uploader .vux-uploader_previewer .vux-uploader_preview-img {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 60px;
        left: 0;
        background: center center/contain no-repeat
    }

    .vux-uploader .vux-uploader_previewer .vux-uploader_del {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: #0d0d0d;
        color: #fff;
        height: 60px;
        line-height: 60px;
        text-align: center;
        font-family: weui
    }

    .vux-uploader .vux-uploader_previewer .vux-uploader_del:after {
        color: #fff;
        font-size: 22px;
        content: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjIiIGhlaWdodD0iMjgiIHZpZXdCb3g9IjAgMCAyMiAyOCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMy4wMTQ2MiAyNi42NDk3QzMuMDQ2MjIgMjcuNDA0NCAzLjY2NzI1IDI4IDQuNDIyNDkgMjhIMTcuNTc3M0MxOC4zMzI1IDI4IDE4Ljk1MzYgMjcuNDA0NCAxOC45ODUyIDI2LjY0OTdMMTkuOTI0NiA2LjgxODE4SDIuMDc1MkwzLjAxNDYyIDI2LjY0OTdaTTEzLjk3NTcgMTEuNzQ0QzEzLjk3NTcgMTEuNDI4IDE0LjIzMTkgMTEuMTcxNyAxNC41NDggMTEuMTcxN0gxNS40NjM0QzE1Ljc3OTQgMTEuMTcxNyAxNi4wMzU4IDExLjQyNzkgMTYuMDM1OCAxMS43NDRWMjMuMDc0MkMxNi4wMzU4IDIzLjM5MDMgMTUuNzc5NiAyMy42NDY1IDE1LjQ2MzQgMjMuNjQ2NUgxNC41NDhDMTQuMjMyIDIzLjY0NjUgMTMuOTc1NyAyMy4zOTA0IDEzLjk3NTcgMjMuMDc0MlYxMS43NDRaTTkuOTY5ODggMTEuNzQ0QzkuOTY5ODggMTEuNDI4IDEwLjIyNjEgMTEuMTcxNyAxMC41NDIyIDExLjE3MTdIMTEuNDU3NkMxMS43NzM1IDExLjE3MTcgMTIuMDI5OSAxMS40Mjc5IDEyLjAyOTkgMTEuNzQ0VjIzLjA3NDJDMTIuMDI5OSAyMy4zOTAzIDExLjc3MzcgMjMuNjQ2NSAxMS40NTc2IDIzLjY0NjVIMTAuNTQyMkMxMC4yMjYyIDIzLjY0NjUgOS45Njk4OCAyMy4zOTA0IDkuOTY5ODggMjMuMDc0MlYxMS43NDRaTTUuOTYzOTYgMTEuNzQ0QzUuOTYzOTYgMTEuNDI4IDYuMjIwMTkgMTEuMTcxNyA2LjUzNjI2IDExLjE3MTdINy40NTE3NkM3Ljc2Nzc2IDExLjE3MTcgOC4wMjQwNSAxMS40Mjc5IDguMDI0MDUgMTEuNzQ0VjIzLjA3NDJDOC4wMjQwNSAyMy4zOTAzIDcuNzY3ODMgMjMuNjQ2NSA3LjQ1MTc2IDIzLjY0NjVINi41MzYyNkM2LjIyMDI2IDIzLjY0NjUgNS45NjM5NiAyMy4zOTA0IDUuOTYzOTYgMjMuMDc0MlYxMS43NDRaIiBmaWxsPSJ3aGl0ZSIvPjxwYXRoIGQ9Ik0yMC41NTAyIDEuNDQyNDJIMTQuNDgxNFYwLjI5NTA5MkMxNC40ODE0IDAuMTMyMTU3IDE0LjM0OTMgMCAxNC4xODYzIDBINy44MTM1MkM3LjY1MDU4IDAgNy41MTg0OSAwLjEzMjE1NyA3LjUxODQ5IDAuMjk1MDkyVjEuNDQyMzVIMS40NDk2OEMwLjk2MTI4NSAxLjQ0MjM1IDAuNTY1NDMgMS44MzgyNyAwLjU2NTQzIDIuMzI2NjdWNS4xMDQ2NEgyMS40MzQ0VjIuMzI2NzRDMjEuNDM0NCAxLjgzODM0IDIxLjAzODYgMS40NDI0MiAyMC41NTAyIDEuNDQyNDJaIiBmaWxsPSJ3aGl0ZSIvPjwvc3ZnPg==)
    }

    .vux-uploader {
        padding: 0
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_input-box {
        border: 1px dashed #ccc;
        box-sizing: border-box;
        border-radius: 4px;
        background: #fff;
        width: 79px;
        height: 79px
    }

    .vux-uploader_input-box {
        cursor: pointer !important;
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_input-box-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        width: 28px;
        height: 28px;
        background-position: center
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_files .vux-uploader_file {
        border-radius: 4px;
        overflow: hidden
    }

    .vux-uploader .vux-uploader_bd .vux-uploader_input-box:after,.vux-uploader .vux-uploader_bd .vux-uploader_input-box:before {
        content: none
    }

    .vux-uploader_preloader {
        border: 1px dashed silver;
    }
</style>
