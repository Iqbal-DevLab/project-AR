   <>
       <style>
           .width-span {
               width: 150px;
           }

           .width-select {
               width: 350px;
           }
       </style>
       <x-page-title>
           <h4 class="text-capitalize">Halaman Proyek</h4>
           <x-breadcrumb>
               <li class="breadcrumb-item active"><a href="#">Halaman Proyek</a></li>
           </x-breadcrumb>
       </x-page-title>
       <div class="row">
           <section>
               <div class="row">
                   <div class="card">
                       <div class="card-body">
                           <div class="card-title">
                               <div>
                                   <button type="button" class="btn btn-primary px-2 py-2" data-bs-toggle="modal"
                                       data-bs-target="#exampleModal">
                                       <i class="bi bi-plus-circle"></i>
                                       <span class="ms-1 fs-6">Tambah Proyek</span>
                                   </button>
                                   <div class="modal fade" id="exampleModal" tabindex="-1"
                                       aria-labelledby="exampleModalLabel" aria-hidden="true">
                                       <div class="modal-dialog modal-lg">
                                           <div class="modal-content">
                                               <div class="modal-header bg-dark">
                                                   <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">FORM
                                                       PROYEK
                                                   </h1>
                                                   <button type="button" class="btn-close btn-close-white"
                                                       data-bs-dismiss="modal" aria-label="Close"></button>
                                               </div>
                                               <form action="/finance/proyek" method="POST">
                                                   @csrf
                                                   <div class="modal-body">
                                                       <div class="row">
                                                           <div class="col mb-3">
                                                               <label for="nama_proyek"
                                                                   class=" col-form-label fs-6">NAMA
                                                                   PROYEK</label>
                                                               <input type="text" class="form-control"
                                                                   id="nama_proyek" name="nama_proyek"
                                                                   placeholder="Masukkan Nama Proyek"
                                                                   pattern="[a-zA-Z 0-9/()_-]+"
                                                                   style="text-transform:uppercase"
                                                                   oninput="this.value = this.value.toUpperCase()">
                                                           </div>
                                                           <div class="col mb-3">
                                                               <label for="kode_proyek" class="col-form-label fs-6">KODE
                                                                   PROYEK</label>

                                                               <input type="text" class="form-control"
                                                                   id="kode_proyek" name="kode_proyek"
                                                                   placeholder="Masukkan Kode Proyek">
                                                           </div>
                                                       </div>
                                                       <div class="mb-3">
                                                           <label for="nilai_kontrak" class="col-form-label fs-6">HARGA
                                                               KONTRAK</label>
                                                           <input type="text" class="form-control" id="harga"
                                                               name="nilai_kontrak"
                                                               placeholder="Masukkan Harga Kontrak">
                                                       </div>
                                                       <div class="mb-3">
                                                           <label for="nama_customer" class="col-form-label fs-6">NAMA
                                                               PEMESAN</label>
                                                           <select class="form-select"
                                                               aria-label="Default select example" id="nama_customer"
                                                               required name="nama_customer">
                                                               <option value="">Pilih Salah Satu</option>
                                                               {{-- @forelse ($customer as $i)
                                                                    <option value="{{ $i->nama_customer }}">
                                                                        {{ $i->nama_customer }}</option>
                                                                @empty
                                                                    <span>Data kosong</span>
                                                                @endforelse --}}
                                                           </select>
                                                       </div>
                                                       <div class="mb-3">
                                                           <label for="sales_id" class="col-form-label fs-6">NAMA
                                                               SALES</label>
                                                           <select class="form-select" id="sales_id" required
                                                               name="sales_id">
                                                               <option value="">Pilih Salah Satu</option>
                                                               {{-- @forelse ($sales as $name)
                                                                    <option value="{{ $name->id }}">
                                                                        {{ $name->nama_sales }}</option>
                                                                @empty
                                                                    <span>Data kosong</span>
                                                                @endforelse --}}
                                                           </select>
                                                       </div>
                                                       <div class="row">
                                                           <div class="col mb-3">
                                                               <label for="tgl_jatuh_tempo"
                                                                   class="col-form-label fs-6">TANGGAL
                                                                   JATUH TEMPO</label>
                                                               <input type="date" class="form-control"
                                                                   id="tgl_jatuh_tempo" name="tgl_jatuh_tempo">
                                                           </div>
                                                           <div class="col mb-3">
                                                               <label for="term_of_payment"
                                                                   class="col-form-label fs-6">TERM OF
                                                                   PAYMENT</label>
                                                               <select class="form-select" id="term_of_payment" required
                                                                   name="term_of_payment">
                                                                   <option value="" hidden>Pilih Salah Satu
                                                                   </option>
                                                                   <option value="10%">DP 10%</option>
                                                                   <option value="15%">DP 15%</option>
                                                                   <option value="20%">DP 20%</option>
                                                                   <option value="25%">DP 25%</option>
                                                                   <option value="30%">DP 30%</option>
                                                               </select>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="modal-footer">
                                                       <button type="submit" class="btn btn-dark">SIMPAN</button>
                                                   </div>
                                               </form>
                                           </div>
                                       </div>
                                   </div>

                                   <button type="button" class="btn btn-primary px-2 py-2 ms-3" data-bs-toggle="modal"
                                       data-bs-target="#ModalUploadProyek">
                                       <i class="bi bi-file-earmark-plus-fill"></i>
                                       <span class="ms-1 fs-6">Upload Proyek</span>
                                   </button>
                                   <div class="modal fade" id="ModalUploadProyek" tabindex="-1"
                                       aria-labelledby="exampleModalLabel" aria-hidden="true">
                                       <div class="modal-dialog">
                                           <div class="modal-content">
                                               <div class="modal-header">
                                                   <h1 class="modal-title fs-5" id="exampleModalLabel">Form Proyek
                                                   </h1>
                                                   <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                       aria-label="Close"></button>
                                               </div>
                                               <form action="{{ route('finance-proyek-upload') }}" method="POST"
                                                   enctype="multipart/form-data">
                                                   <div class="modal-body">
                                                       @csrf
                                                       <div class="mb-3">
                                                           <label for="formFileSm" class="form-label">Masukkan File
                                                               Proyek</label>
                                                           <input class="form-control form-control-sm" id="formFileSm"
                                                               type="file" name="file">
                                                       </div>
                                                   </div>
                                                   <div class="modal-footer">
                                                       <button type="button" class="btn btn-secondary"
                                                           data-bs-dismiss="modal">Close</button>
                                                       <button type="submit" class="btn btn-primary">Submit</button>
                                                   </div>
                                               </form>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <table class='table styled-table table-striped table-hover' id="table1">
                               <thead>
                                   <tr>
                                       <th>NO</th>
                                       <th>NAMA PROYEK</th>
                                       <th>KODE PROYEK</th>
                                       <th>SALES</th>
                                       <th>HARGA KONTRAK</th>
                                       <th>PAYMENT TERMS</th>
                                       <th>TANGGAL JATUH TEMPO</th>
                                       <th>STATUS</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   {{-- @foreach ($proyeks as $proyek)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $proyek->nama_proyek }}</td>
                                            <td>{{ $proyek->kode_proyek }}</td>
                                            <td>{{ $proyek->nama_sales }}</td>
                                            <td>@currency($proyek->nilai_kontrak),-</td>
                                            <td>{{ $proyek->term_of_payment }}</td>
                                            <td>{{ \Carbon\Carbon::parse($proyek->tgl_jatuh_tempo)->format('d F Y') }}</td>
                                            <td><span class="badge bg-primary rounded-2 fs-6">Aktif</span></td>
                                        </tr>
                                    @endforeach --}}
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
               @include('sweetalert::alert')
           </section>
       </div>
       <script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
       <script src="/assets/js/vendors.js"></script>
       <script src="/assets/vendors/choices.js/choices.min.js"></script>
       <script src="/assets/js/superadmin/edituser.js"></script>
       <script>
           $(document).ready(function() {
               $('#detail').on('click', function() {
                   let id = $(this).data('id');
                   // let url = '/supervisor/detail-data/' + id;
                   // $.ajax({
                   //     url: url,
                   //     type: 'GET',
                   //     dataType: 'json',
                   //     success: function(data) {
                   //         $('#showData').modal('show');
                   //         $('#id_proyek').val(data.detail[0].id);
                   //     }
                   // });
               });
           });
       </script>
       <script>
           var hargaInput = document.getElementById('harga');
           hargaInput.addEventListener('keyup', function(event) {
               // Hilangkan semua karakter selain angka
               var harga = this.value.replace(/\D/g, '');

               // Format harga dengan tanda koma setiap 3 angka
               harga = harga.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

               // Set nilai input field
               this.value = harga;
           });
       </script>
   </>
