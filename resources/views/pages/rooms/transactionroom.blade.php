@extends('main')

@section('content')
@if (session()->has('success'))
  <script>
      $(document).ready(function(){
          $("#successModal").modal('toggle');
      });
  </script>
@endif
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header px-3">
          <div class="row">
            <div class="col-6 d-flex align-items-center">
              <h4 class="mb-0">List Transactions</h4>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Room Number</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">From</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">To</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($transactions as $transaction)
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md me-3">
                        <i class="fas fa-bed text-lg opacity-10" aria-hidden="true"></i>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">{{$transaction->room->room_number}}</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">{{$transaction->fromDate}}</p>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">{{$transaction->toDate}}</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="badge badge-sm bg-gradient-success">{{number_format($transaction->price)}}</span>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{$transaction->status}}</span>
                  </td>
                  <td class="align-middle text-center">
                    @if ($transaction->payment_status)
                       <a href="#"> <span class="badge badge-sm bg-gradient-success">Lunas</span></a>
                    @else
                        <a href="#"> <span class="badge badge-sm bg-gradient-warning">Belum Lunas</span></a>
                    @endif
                  </td>
                  <td class="align-middle text-center">
                    <button class="btn btn-link text-secondary mb-0" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-ellipsis-v text-xs"></i>
                    </button>
                    <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                      <li>
                        <button class="dropdown-item border-radius-md" data-id="{{$transaction->id}}" onclick="update(this)" data-bs-toggle="modal" data-bs-target="#deleteModal" id="deleteRoom">
                          <span class="d-inline">Update</span>
                        </button>
                      </li>
                    </ul>
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
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col text-center">
                <i class="fas fa-check-circle text-success fs-1"></i>
                <h4>Success</h4>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col text-center">
                <p>Update Transaction Success</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Transaction</h5>
        </div>
        <div class="modal-body">
          <form action="/rooms/transactions/update" method="post">
            @csrf
          <div class="container">
            <input type="hidden" name="id" id="tr_id">
            <label>Payment Status</label>
            <div class="mb-3">
                <select class="form-select" name="payment_status">
                    <option value="true" selected>Lunas</option>
                    <option value="false">Belum Lunas</option>
                </select>
            </div>
            <label>Status</label>
            <div class="mb-3">
                <select class="form-select" name="status">
                    <option value="cancel">cancel</option>
                    <option value="active" selected>active</option>
                    <option value="done">done</option>
                </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </form>  
      </div>
    </div>
  </div>

  <script>
    function update(event){
      var transactionId = event.dataset.id
      console.log(transactionId);
      var transactionForm = document.getElementById('tr_id')

      transactionForm.value = transactionId
    }
  </script>
@endsection