<style>
    /* Large, readable image previews in all CMS upload fields */
    .fi-fo-file-upload .filepond--root[data-style-panel-layout='integrated'] {
        min-height: 14rem;
    }

    .fi-fo-file-upload .filepond--root[data-style-panel-layout='integrated'] .filepond--image-preview-wrapper {
        min-height: 12rem !important;
    }

    .fi-fo-file-upload .filepond--image-preview {
        background: #f4f4f5 !important;
    }

    .fi-fo-file-upload .filepond--image-preview img,
    .fi-fo-file-upload .filepond--image-clip img,
    .fi-fo-file-upload .filepond--image-clip canvas {
        object-fit: contain !important;
        max-height: 100%;
        width: 100% !important;
    }

    .fi-fo-file-upload .filepond--file {
        min-height: 12rem;
    }

    .fi-fo-file-upload .filepond--file-action-button.filepond--action-edit-item {
        width: 2.5rem;
        height: 2.5rem;
        background: rgb(0 0 0 / 0.7) !important;
    }

    .fi-fo-file-upload .filepond--file-action-button.filepond--action-remove-item {
        width: 2.25rem;
        height: 2.25rem;
    }
</style>
