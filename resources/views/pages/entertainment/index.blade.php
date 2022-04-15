@extends('main')

@section('content')
@if (session()->has('success'))
<script>
    $(document).ready(function() {
        $("#successModal").modal('toggle');
    });
</script>
@endif
<style>
    .dz-progress {
        display: none;
    }

    .dropzone .dz-preview.dz-error .dz-image {
        background: var(--bs-danger) !important;
        opacity: 0.7;
    }

    .dropzone .dz-preview.dz-error.dz-image-preview .dz-image img {
        opacity: 0.5;
    }

    .dropzone .dz-preview .dz-error-message {
        top: 144px
    }

    .dz-remove {
        color: var(--bs-danger);
        font-weight: bold;
    }

    .dropzone {
        border: 1px solid #d2d6da;
    }

    .pswp-gallery a {
        max-width: 33%;
    }

    .pswp-gallery img {
        width: 100%;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header px-3">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <h4 class="mb-0">List Entertainments</h4>
                        @csrf
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn bg-gradient-dark btn-block mb-3" data-bs-toggle="modal" data-bs-target="#addEntertainmentModal" onclick="onClickAdd()"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add New Entertainment</button>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive px-4 py-2">
                    <table class="table align-items-center mb-0" id="table-entertainment">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Entertainments Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Allotment</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-entertaintment"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<!-- data-bs-backdrop="static" -->
<div class="modal fade" id="addEntertainmentModal" tabindex="-1" role="dialog" aria-labelledby="addEntertainmentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="title-add-modal-entertainment"></span> Entertainment</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-entertainment">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama" class="col-form-label">Entertainment Name:</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="harga" class="col-form-label">Entertainment Price:</label>
                        <input type="number" class="form-control" id="harga" name="harga">
                    </div>
                    <div class="form-group">
                        <label for="kategori" class="col-form-label">Entertainment Category:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kategori" id="food-beverages-radio" value="Food & Beverages">
                            <label class="custom-control-label" for="food-beverages-radio">Food & Beverages</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kategori" id="indoor-radio" value="Indoor">
                            <label class="custom-control-label" for="indoor-radio">Indoor</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kategori" id="outdoor-radio" value="Outdoor">
                            <label class="custom-control-label" for="outdoor-radio">Outdoor</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="peruntukan" class="col-form-label">Entertainment Allotment:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="peruntukan" id="room-radio" value="Room">
                            <label class="custom-control-label" for="room-radio">Room</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="peruntukan" id="ballroom-radio" value="Ballroom">
                            <label class="custom-control-label" for="ballroom-radio">Ballroom</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class="col-form-label">Entertainment Description:</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="dropzoneForm" class="col-form-label">Entertainment Images:</label>
                        <div class="pswp-gallery flex-wrap justify-content-center" id="list-image-edit" style="display: flex;"></div>
                        <div id="dropzoneForm" class="dropzone form-control"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal" id="close-add-enterteinment-button">Close</button>
                    <button type="submit" class="btn bg-gradient-primary">
                        <!-- <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> -->
                        <span id="button-tittle-add-modal-entertainment"></span> Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteEntertainmentModal" tabindex="-1" aria-labelledby="deleteEntertainmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col">
                        <h4>Are You Sure?</h4>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col">
                        <p class="m-0">Do you really want to delete <b id="delete-entertainment-nama"></b> from the entertainment list?</p>
                        <p>Deleted data cannot be recovered again!</p>
                        <input type="hidden" name="delete-entertainment-input" id="delete-entertainment-input">
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary m-0 mx-2" data-bs-dismiss="modal" id="close-delete-enterteinment-button">Cancel</button>
                    <button type="button" class="btn btn-danger m-0" onclick="onClickDeleteModal()">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailEntertainmentModal" role="dialog" aria-labelledby="detailEntertainmentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Entertainment Detail</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="pswp-gallery d-flex flex-wrap justify-content-center" id="list-image-detail"></div>
                <div class="row mt-5">
                    <div class="col-12 col-md-6">
                        <p class="m-0"><strong>Name:</strong></p>
                        <p id="detail-nama"></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="m-0"><strong>Price:</strong></p>
                        <p id="detail-harga"></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="m-0"><strong>Category:</strong></p>
                        <p id="detail-kategori"></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="m-0"><strong>Allotment:</strong></p>
                        <p id="detail-peruntukan"></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="m-0"><strong>Created At:</strong></p>
                        <p id="detail-created"></p>
                    </div>
                    <div class="col-12">
                        <p class="m-0"><strong>Description:</strong></p>
                        <p id="detail-deskripsi"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal" id="close-add-enterteinment-button">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto text-success" id="toast-title">Successfully Adding Data</strong>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="toast" aria-label="Close"><span>×</span></button>
        </div>
        <div class="toast-body" id="toast-body">
            The entertainment data has been successfully added!
        </div>
    </div>
</div>


<script type="module" src="/assets/js/photoswipe.js"></script>

<script>
    const token = document.querySelector('meta[name="csrf-token').getAttribute('content')
    let table
    let isEdit = false
    let editId
    Dropzone.autoDiscover = false

    let myDropzone = new Dropzone("#dropzoneForm", {
        autoProcessQueue: false,
        url: "/file/post",
        acceptedFiles: "image/*",
        maxFiles: 5,
        addRemoveLinks: true
    });

    const clearForm = () => {
        const titel = document.querySelector('#title-add-modal-entertainment')
        const tombol = document.querySelector('#button-tittle-add-modal-entertainment')

        document.querySelector('#dropzoneForm').style.display = "block"
        if (isEdit) {
            titel.innerHTML = 'Edit'
            tombol.innerHTML = 'Edit'
            document.querySelector('#list-image-edit').style.display = "flex"
        } else {
            titel.innerHTML = 'Add New'
            tombol.innerHTML = 'Add'
            document.querySelector('#list-image-edit').style.display = "none"
        }
        document.querySelector('#nama').value = ''
        document.querySelector('#harga').value = ''
        document.querySelector('#deskripsi').value = ''
        document.querySelectorAll('[name="kategori"]').forEach(element => {
            element.checked = false
        })
        document.querySelectorAll('[name="peruntukan"]').forEach(element => {
            element.checked = false
        })
        myDropzone.removeAllFiles(true)
    }

    const formatDate = (tanggal) => {
        const zeroAdder = (item) => {
            return item < 10 ? '0' + item : item
        }
        const date = new Date(tanggal)
        const s = zeroAdder(date.getSeconds())
        const m = zeroAdder(date.getMinutes())
        const h = zeroAdder(date.getHours())
        const dd = zeroAdder(date.getDate())
        const mm = zeroAdder(date.getMonth() + 1)
        const yy = date.getFullYear()
        return `${dd}-${mm}-${yy} | ${h}:${m}:${s}`
    }

    const fetchEntertainment = async (id) => {
        const getEntertainment = await fetch(`/entertainment/read?id=${id}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
        return getEntertainment
    }

    const onClickDeleteModal = async () => {
        const id = document.querySelector('#delete-entertainment-input').value
        const deleteEntertainment = await fetch('/entertainment/delete', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id
            })
        });
        if (deleteEntertainment.status !== 200) {
            document.querySelector('#toast-title').classList.add('text-danger')
            document.querySelector('#toast-title').innerHTML = 'Failed Deleting Data'
            document.querySelector('#toast-body').innerHTML = 'The entertainment data failed to be deleted!'
            showToast()
            document.querySelector('#close-delete-enterteinment-button').click()
            return
        }
        table.rows(`.tr-${id}`).remove().draw();
        document.querySelector('#toast-title').classList.remove('text-danger')
        document.querySelector('#toast-title').innerHTML = 'Successfully Deleting Data'
        document.querySelector('#toast-body').innerHTML = 'The entertainment data has been successfully deleted!'

        showToast()
        document.querySelector('#close-delete-enterteinment-button').click()
    }

    const onClickDelete = async (id, nama) => {
        document.querySelector('#delete-entertainment-nama').innerHTML = nama
        document.querySelector('#delete-entertainment-input').value = id
    }

    const onClickDetail = async (id) => {
        let images = ''
        const entertainment = await (await fetchEntertainment(id)).json()
        entertainment.data.images.forEach((element) => {
            images += `<a href="${element.path}" data-pswp-width="4110" data-pswp-height="2800" data-cropped="true" target="_blank"><img src="${element.path}" alt="${element.nama}"/></a>`
        })
        document.querySelector('#list-image-detail').innerHTML = images
        document.querySelector('#detail-nama').innerHTML = entertainment.data.nama
        document.querySelector('#detail-harga').innerHTML = entertainment.data.harga
        document.querySelector('#detail-kategori').innerHTML = entertainment.data.kategori
        document.querySelector('#detail-peruntukan').innerHTML = entertainment.data.peruntukan
        document.querySelector('#detail-created').innerHTML = formatDate(entertainment.data.created_at)
        document.querySelector('#detail-deskripsi').innerHTML = entertainment.data.deskripsi
    }

    const removeImage = async (event, id) => {
        event.preventDefault()
        event.stopPropagation()
        console.log(id)
    }

    const onClickEdit = async (id) => {
        isEdit = true
        clearForm()
        let images = ''
        editId = id
        const entertainment = await (await fetchEntertainment(id)).json()
        const imagesLength = entertainment.data.images.length
        if (imagesLength >= 5) document.querySelector('#dropzoneForm').style.display = "none"
        myDropzone.options.maxFiles = 5 - imagesLength
        entertainment.data.images.forEach((element) => {
            images += `<a href="${element.path}" class="position-relative" data-pswp-width="4110" data-pswp-height="2800" data-cropped="true" target="_blank"><img src="${element.path}" alt="${element.nama}"/><button type="button" class="btn btn-icon bg-gradient-danger position-absolute top-0 end-0 me-2 mt-2 mb-0" onclick="removeImage(event, '${element.id}')"><i class="fas fa-trash-alt"></i></button></a>`
        })
        console.log(entertainment)
        document.querySelector('#nama').value = entertainment.data.nama
        document.querySelector('#harga').value = entertainment.data.harga
        document.querySelector('#deskripsi').value = entertainment.data.deskripsi
        document.querySelectorAll('[name="kategori"]').forEach(element => {
            if (element.value === entertainment.data.kategori) element.checked = true
        })
        document.querySelectorAll('[name="peruntukan"]').forEach(element => {
            if (element.value === entertainment.data.peruntukan) element.checked = true
        })
        document.querySelector('#list-image-edit').innerHTML = images
    }

    const onClickAdd = () => {
        isEdit = false
        clearForm()
    }

    const trTable = (id, nama, harga, kategori, peruntukan, tanggal) => {
        return `<tr class="tr-${id}"><td>${nama}</td><td>${harga}</td><td>${kategori}</td><td>${peruntukan}</td><td>${tanggal}</td><td class="d-flex justify-content-center align-items-center"><button class="btn btn-icon btn-2 btn-secondary mx-1 mb-0" type="button" data-bs-toggle="modal" data-bs-target="#detailEntertainmentModal" onclick="onClickDetail('${id}')"><i class="fas fa-search"></i></button><button class="btn btn-icon btn-2 btn-warning mx-1 mb-0" type="button" data-bs-toggle="modal" data-bs-target="#addEntertainmentModal" onclick="onClickEdit('${id}')"><i class="fas fa-edit"></i></button><button class="btn btn-icon btn-2 btn-danger mx-1 mb-0" type="button" data-bs-toggle="modal" data-bs-target="#deleteEntertainmentModal" onclick="onClickDelete(${id}, '${nama}')"><i class="fas fa-trash-alt"></i></button></td></tr>`
    }

    const getAllData = async () => {
        const getAllEntertainment = await fetch('/entertainment/read-all', {
            headers: {
                'X-CSRF-TOKEN': token
            },
        });
        const data = await getAllEntertainment.json()
        let tr = ''
        data.data.forEach(element => {
            tr += trTable(element.id, element.nama, element.harga, element.kategori, element.peruntukan, element.created_at)
        });
        document.querySelector('#tbody-entertaintment').innerHTML = tr
        table = new DataTable('#table-entertainment', {
            order: [
                [4, "desc"]
            ],
            columnDefs: [{
                targets: 4,
                render: (data) => {
                    return formatDate(data)
                }
            }, {
                targets: 5,
                orderable: false
            }]
        })
    }
    getAllData()

    const showToast = () => {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl)
        })
        toastList.forEach(toast => toast.show())
    }

    const checkChecked = (arr) => {
        let data = [];
        arr.forEach(element => {
            if (element.checked) data.push(element.value)
        });
        return data.join()
    }

    const submitEntertaintment = async () => {
        const formData = new FormData(); // form data untuk post data ke server
        // value dari form semuanya
        const nama = document.querySelector('#nama').value
        const harga = document.querySelector('#harga').value
        const kategori = checkChecked(document.querySelectorAll('[name="kategori"]'))
        const peruntukan = checkChecked(document.querySelectorAll('[name="peruntukan"]'))
        const deskripsi = document.querySelector('#deskripsi').value

        // append data dari form ke form data
        formData.append('nama', nama)
        formData.append('harga', harga)
        formData.append('kategori', kategori)
        formData.append('peruntukan', peruntukan)
        formData.append('deskripsi', deskripsi)

        // get data files dari dropzone
        myDropzone.files.filter(item => item.status === "queued").forEach((item, index) => {
            formData.append(`fotos[${index}]`, item)
        });

        // post data ke API server
        const postData = await fetch('/entertainment/create', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            body: formData
        })
        if (postData.status !== 201) {
            document.querySelector('#toast-title').classList.add('text-danger')
            document.querySelector('#toast-title').innerHTML = 'Failed Adding Data'
            document.querySelector('#toast-body').innerHTML = 'The entertainment data failed to be added!'
            showToast()
            document.querySelector('#close-add-enterteinment-button').click()
            return
        }
        document.querySelector('#toast-title').classList.remove('text-danger')
        document.querySelector('#toast-title').innerHTML = 'Successfully Adding Data'
        document.querySelector('#toast-body').innerHTML = 'The entertainment data has been successfully added!'

        showToast()
        clearForm()
        document.querySelector('#close-add-enterteinment-button').click()
        return await postData.json()
    }

    const submitEditEntertainment = async () => {
        const formData = new FormData(); // form data untuk post data ke server
        // value dari form semuanya
        const nama = document.querySelector('#nama').value
        const harga = document.querySelector('#harga').value
        const kategori = checkChecked(document.querySelectorAll('[name="kategori"]'))
        const peruntukan = checkChecked(document.querySelectorAll('[name="peruntukan"]'))
        const deskripsi = document.querySelector('#deskripsi').value

        // append data dari form ke form data
        formData.append('id', editId)
        formData.append('nama', nama)
        formData.append('harga', harga)
        formData.append('kategori', kategori)
        formData.append('peruntukan', peruntukan)
        formData.append('deskripsi', deskripsi)

        // get data files dari dropzone
        myDropzone.files.filter(item => item.status === "queued").forEach((item, index) => {
            formData.append(`fotos[${index}]`, item)
        });

        // post data ke API server
        const postData = await fetch('/entertainment/update', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            body: formData
        })
        if (postData.status !== 200) {
            document.querySelector('#toast-title').classList.add('text-danger')
            document.querySelector('#toast-title').innerHTML = 'Failed Editing Data'
            document.querySelector('#toast-body').innerHTML = 'The entertainment data failed to be edited!'
            showToast()
            document.querySelector('#close-add-enterteinment-button').click()
            return
        }
        document.querySelector('#toast-title').classList.remove('text-danger')
        document.querySelector('#toast-title').innerHTML = 'Successfully Editing Data'
        document.querySelector('#toast-body').innerHTML = 'The entertainment data has been successfully edited!'

        showToast()
        clearForm()
        document.querySelector('#close-add-enterteinment-button').click()
        return await postData.json()
    }

    document.querySelector('#form-entertainment').addEventListener('submit', async (e) => {
        e.preventDefault()
        if (isEdit) {
            const dataEntertainment = await submitEditEntertainment()
            const tr = trTable(dataEntertainment.data.id, dataEntertainment.data.nama, dataEntertainment.data.harga, dataEntertainment.data.kategori, dataEntertainment.data.peruntukan, dataEntertainment.data.created_at)
            table.rows(`.tr-${dataEntertainment.data.id}`).remove().draw();
            table.row.add($(tr)).draw()
        } else {
            const dataEntertainment = await submitEntertaintment()
            const tr = trTable(dataEntertainment.data.id, dataEntertainment.data.nama, dataEntertainment.data.harga, dataEntertainment.data.kategori, dataEntertainment.data.peruntukan, dataEntertainment.data.created_at)
            table.row.add($(tr)).draw()
        }
    })
</script>

@endsection