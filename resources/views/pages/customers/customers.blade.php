@extends('main') @section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header px-3">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <h4 class="mb-0">List Customers</h4>
                        @csrf
                    </div>
                    <div class="col-6 text-end">
                        <a
                            class="btn bg-gradient-dark mb-0"
                            data-bs-toggle="modal"
                            data-bs-target="#addCustomerModal"
                            ><i class="fas fa-plus"></i>&nbsp;&nbsp;Add New
                            Customer</a
                        >
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                >
                                    Name
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                >
                                    ID Number
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                >
                                    Email
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                >
                                    Phone
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                >
                                    Action
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                >
                                    Status
                                </th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div
                                            class="d-flex flex-column justify-content-center"
                                        >
                                            <h6 class="text-secondary text-xs font-weight-bold">
                                                {{$customer->name}}
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span
                                        class="text-secondary text-xs font-weight-bold"
                                        >{{$customer->numberid}}</span
                                    >
                                </td>
                                <td class="align-middle text-center">
                                    <span
                                        class="text-secondary text-xs font-weight-bold"
                                        >{{$customer->email}}</span
                                    >
                                </td>
                                <td class="align-middle text-center">
                                    <span
                                        class="text-secondary text-xs font-weight-bold"
                                        >{{$customer->phone}}</span
                                    >
                                </td>
                                <td class="align-middle text-center">
                                    <a
                                        class="btn btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editCustomerModal"
                                        data-params="<?= htmlspecialchars(json_encode($customer), ENT_QUOTES, 'UTF-8') ?>"
                                        onclick="edit(this)"
                                    >
                                        Edit
                                    </a>
                                </td>
                                <td class="align-middle text-center">
                                    <?php
                                    if($customer->isActive == 0){
                                        echo '<a
                                        href="customers/activate-customer?id='.$customer->id.'"
                                        class="btn btn-success"
                                        data-toggle="tooltip"
                                        data-original-title="active-customer"
                                    >
                                        Active
                                    </a>';
                                    }else{
                                        echo '<a
                                        href="customers/deactivate-customer?id='.$customer->id.'"
                                        class="btn btn-danger"
                                        data-toggle="tooltip"
                                        data-original-title="non-active-customer"
                                    >
                                        Non-active
                                    </a>';
                                    }

                                    ?>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div
    class="modal fade"
    id="addCustomerModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="addCustomerModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">
                    Add Customer
                </h5>
                <button
                    type="button"
                    class="btn-close text-dark"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-customer" action="customers/add-customer" method="post">
            @csrf
            <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                        />
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-form-label"
                            >Username:</label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            name="username"
                        />
                    </div>
                    <div class="form-group">
                        <label for="id-number" class="col-form-label"
                            >ID Number:</label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="id-number"
                            name="id-number"
                        />
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email:</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                        />
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label"
                            >Password:</label
                        >
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                        />
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label"
                            >Phone Number:</label
                        >
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon3"
                                >+62</span
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="phone"
                                name="phone"
                            />
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                >
                    Close
                </button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div
    class="modal fade"
    id="editCustomerModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="editCustomerModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCustomerModalLabel">
                    Edit Customer
                </h5>
                <button
                    type="button"
                    class="btn-close text-dark"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-customer" action="customers/edit-customer" method="post">
            @csrf
            <input type="hidden" class="form-control" id="edit-id" name="id">
            <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="edit-name"
                            name="name"
                        />
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-form-label"
                            >Username:</label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="edit-username"
                            name="username"
                        />
                    </div>
                    <div class="form-group">
                        <label for="id-number" class="col-form-label"
                            >ID Number:</label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="edit-id-number"
                            name="id-number"
                        />
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email:</label>
                        <input
                            type="email"
                            class="form-control"
                            id="edit-email"
                            name="email"
                        />
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label"
                            >Password:</label
                        >
                        <input
                            type="password"
                            class="form-control"
                            id="edit-password"
                            name="password"
                        />
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label"
                            >Phone Number:</label
                        >
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon3"
                                >+62</span
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="edit-phone"
                                name="phone"
                            />
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                >
                    Close
                </button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
        </form>
    </div>
</div>

<script>
    const edit = (costumerElement) => {
        const dataCostumer = JSON.parse(costumerElement.getAttribute('data-params'))
        console.log(dataCostumer)
        document.querySelector('#edit-id').value = dataCostumer.id;
        document.querySelector('#edit-name').value = dataCostumer.name;
        document.querySelector('#edit-username').value = dataCostumer.username;
        document.querySelector('#edit-id-number').value = dataCostumer.numberid;
        document.querySelector('#edit-email').value = dataCostumer.email;
        document.querySelector('#edit-password').value = dataCostumer.password;
        document.querySelector('#edit-phone').value = dataCostumer.phone;
    }
</script>

@endsection
