<x-app-layout>
	<x-slot name="head">
		<link rel="stylesheet" href="{{ asset('dist/vendor/datatables/buttons.dataTables.min.css') }}">
	</x-slot>
	<x-slot name="title">Laporan</x-slot>

	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif

	<x-card>
		<x-slot name="title">Semua Laporan</x-slot>

		<table class="table table-hover mb-3">
			<thead>
				<th>Nama Barang</th>
				<th>Dari/Kepada</th>
				<th>Harga</th>
				<th>Stok</th>
				<th>Berat</th>
				<th>Tanggal</th>
				<th>Aksi</th>
			</thead>
			<tbody>
				@foreach ($data as $row)
					<tr>
						<td>{{ $row->nama }}</td>
						<td>{{ $row->orang }}</td>
						<td>{{ $row->harga }}</td>
						<td>{{ $row->jumlah }}</td>
						<td>{{ $row->berat }}kg</td>
						<td>{{ $row->created_at->format('d-m-Y') }}</td>
						<td><span class="badge badge-{{ ($row->jenis == 'Barang Masuk') ? 'success' : 'danger' }}">{{ $row->jenis }}</span></td>
					</tr>
				@endforeach
				
			</tbody>
		</table>
	</x-card>

	

	<x-slot name="script">
		<script src="{{ asset('dist/vendor/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('dist/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('dist/vendor/datatables/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('dist/vendor/datatables/jszip.min.js') }}"></script>
		<script src="{{ asset('dist/vendor/datatables/pdfmake.min.js') }}"></script>
		<script src="{{ asset('dist/vendor/datatables/vfs_fonts.js') }}"></script>
		<script src="{{ asset('dist/vendor/datatables/buttons.html5.min.js') }}"></script>
		<script>

			$(document).ready(function () {
		      $('table').DataTable({
			        dom: 'Bfrtip',
			        buttons: [
			            'excelHtml5',
			            'csvHtml5',
			            'pdfHtml5'
			        ]
			    } );
		    });
		</script>
	</x-slot>
</x-app-layout>