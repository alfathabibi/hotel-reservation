import PhotoSwipeLightbox from "https://unpkg.com/photoswipe/dist/photoswipe-lightbox.esm.js";

const lightboxDetail = new PhotoSwipeLightbox({
    gallery: "#list-image-detail",
    children: "a",
    pswpModule: () => import("https://unpkg.com/photoswipe"),
});
lightboxDetail.init();

const lightboxEdit = new PhotoSwipeLightbox({
    gallery: "#list-image-edit",
    children: "a",
    pswpModule: () => import("https://unpkg.com/photoswipe"),
});
lightboxEdit.init();
