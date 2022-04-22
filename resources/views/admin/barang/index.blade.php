<x-app-layout>
	<x-slot name="title">Daftar Barang</x-slot>

	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif

	<x-card>
		<x-slot name="title">Semua Barang</x-slot>
		<x-slot name="option">
			<div>
				<button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Filter Gudang
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            	<a href="{{ route('admin.barang.index') }}" class="dropdown-item">Semua Gudang</a>
            	@foreach ($gudang as $row)
				<a class="dropdown-item" href="{{ route('admin.barang.index') }}?filter_gudang={{ $row->id }}">{{ $row->nama }}</a>
				@endforeach
                  
                </div>
				<button class="btn btn-primary add"><i class="fas fa-plus"></i> Tambah Barang</button>
			</div>
		</x-slot>

		<table class="table table-hover mb-3" id="daftar">
			<thead>
				<tr>
					<th>Kode Barang</th>
					<th>Nama Barang</th>
					<th>Jumlah Barang</th>
					<th>Kondisi Barang</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $row)
					<tr>
						<td>{{ $row->kode }}</td>
						<td>{{ $row->nama }}</td>
						<td>{{ $row->jumlah }}</td>
						<td>
							@if ($row->kondisi == 0)
								<span class="badge badge-success">Baru</span>
							@else
								<span class="badge badge-warning">Bekas</span>
							@endif
						</td>
						<td class="text-center">
							<button class="btn btn-sm btn-info info" data-id="{{ $row->id }}"><i class="fas fa-info-circle"></i></button>
							<button class="btn btn-sm btn-primary edit" data-id="{{ $row->id }}"><i class="fas fa-edit"></i></button>
							<form action="{{ route('admin.barang.destroy', $row->id) }}" style="display: inline-block;" method="POST">
							@csrf
							<button type="button" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></button>
						</form>
						</td>
					</tr>
				@endforeach
				
			</tbody>
		</table>
	</x-card>

	{{-- add model --}}
	<x-modal>
		<x-slot name="title">
			<h6 class="m-0 font-weight-bold text-primary">Tambahkan Barang</h6>
		</x-slot>
		<x-slot name="id">add</x-slot>


		<form action="{{ route('admin.barang.store') }}" method="post" class="form-group">
			@csrf
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="">Kode Barang</label>
						<input type="text" class="form-control" name="kode" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="">Nama Barang</label>
						<input type="text" class="form-control" name="nama" required="">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="">Tempat Penyimpanan</label>
				<select name="gudang_id" class="form-control">
					<option value="">--- Pilih Gudang ---</option>
					@foreach ($gudang as $row)
						<option value="{{ $row->id }}">{{ $row->nama }}</option>
					@endforeach
				</select>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="">Jumlah Barang</label>
						<input type="number" class="form-control" name="jumlah" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="">Kondisi Barang</label>
						<select name="kondisi" class="form-control">
							<option value="">--- Pilih Kondisi ---</option>
							<option value="0">Baru</option>
							<option value="1">Bekas</option>
						</select>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</form>
	</x-modal>

	{{-- edit model --}}
	<x-modal>
		<x-slot name="title">
			<h6 class="m-0 font-weight-bold text-primary">Edit Gudang</h6>
		</x-slot>
		<x-slot name="id">edit</x-slot>


		<form action="{{ route('admin.barang.update') }}" method="post" id="edit" class="form-group">
			@csrf
			<input type="hidden" name="id" value="">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="">Kode Barang</label>
						<input type="text" class="form-control" name="kode" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="">Nama Barang</label>
						<input type="text" class="form-control" name="nama" required="">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="">Tempat Penyimpanan</label>
				<select name="gudang_id" class="form-control">
					<option value="">--- Pilih Gudang ---</option>
					@foreach ($gudang as $row)
						<option value="{{ $row->id }}">{{ $row->nama }}</option>
					@endforeach
				</select>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="">Jumlah Barang</label>
						<input type="number" class="form-control" name="jumlah" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="">Kondisi Barang</label>
						<select name="kondisi" class="form-control">
							<option value="">--- Pilih Kondisi ---</option>
							<option value="0">Baru</option>
							<option value="1">Bekas</option>
						</select>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</form>
	</x-modal>

	{{-- info modal --}}
	<x-modal>
		<x-slot name="title">
			<h6 class="m-0 font-weight-bold text-primary">Informasi Gudang</h6>
		</x-slot>
		<x-slot name="id">info</x-slot>

		<div class="row">
			<div class="col-md-6">
				<span>Nama Barang</span>
			</div>
			<div class="col-md-6">
				<span class="mr-2">:</span><span id="nama"></span>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<span>Kode Barang</span>
			</div>
			<div class="col-md-6">
				<span class="mr-2">:</span><span id="kode"></span>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<span>Gudang</span>
			</div>
			<div class="col-md-6">
				<span class="mr-2">:</span><span id="gudang"></span>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<span>Jumlah</span>
			</div>
			<div class="col-md-6">
				<span class="mr-2">:</span><span id="jumlah"></span>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<span>Kondisi</span>
			</div>
			<div class="col-md-6">
				<span class="mr-2">:</span><span id="kondisi"></span>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<span>Tanggal Ditambahkan</span>
			</div>
			<div class="col-md-6">
				<span class="mr-2">:</span><span id="tgl"></span>
			</div>
		</div>
	</x-modal>

	<x-slot name="script">
		<script src="{{ asset('dist/vendor/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('dist/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
		<script>
			$('.add').click(function() {
				$('#add').modal('show')
			})

			$('.info').click(function() {
				const id = $(this).data('id')

				$.get(`{{ route('admin.barang.info') }}?id=${id}`, function(data) {
					$('#nama').text(data.barang.nama)
					$('#kode').text(data.barang.kode)
					$('#gudang').text(data.gudang.nama)
					$('#jumlah').text(data.barang.jumlah)
					$('#tgl').text(new Date(data.barang.created_at).toLocaleString())
					$('#kondisi').text((data.barang.kondisi==0) ? 'Baru' : 'Bekas')
				})

				$('#info').modal('show')
			})

			$('.edit').click(function() {
				const id = $(this).data('id')

				$.get(`{{ route('admin.barang.info') }}?id=${id}`, function(data) {
					$('#edit input[name="id"]').val(id)

					$('#edit input[name="nama"]').val(data.barang.nama)
					$('#edit input[name="kode"]').val(data.barang.kode)
					$('#edit input[name="jumlah"]').val(data.barang.jumlah)
					$(`#edit option[value="${data.gudang.id}"]`).attr('selected', 'true')
					$(`#edit select[name="kondisi"] option[value="${data.barang.kondisi}"]`).attr('selected', 'true')
				})

				$('#edit').modal('show')
			})

			$('.delete').click(function(e){
				e.preventDefault()
				Swal.fire({
				  title: 'Ingin menghapus?',
				  text: 'Data akan dihapus permanen',
				  icon: 'warning',
				  showCancelButton: true,
				  confirmButtonText: 'Hapus',
				  cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.isConfirmed) {
				  		$(this).parent().submit()
					} 
				})

			})

			$(document).ready(function () {
		      $('#daftar').DataTable();
		    });
		</script>
	</x-slot>
</x-app-layout>