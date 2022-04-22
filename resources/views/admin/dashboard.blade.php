<x-app-layout>
    <x-slot name="title">
        Dahsboard
    </x-slot>

    <section class="row">
        <x-card-sum 
            text="Total Supplier" 
            value="{{ $supplier }}" 
            icon="users" 
            color="warning"
        />
        <x-card-sum 
            text="Total Barang" 
            value="{{ $jumlah_barang }}" 
            icon="box" 
            color="primary"
        />
        <x-card-sum 
            text="Jumlah Gudang" 
            value="{{ $jumlah_gudang }}" 
            icon="th" 
            color="success"
        />
        <x-card-sum 
            text="Keluar Masuk Barang" 
            value="{{ $in_out }}" 
            icon="chart-line" 
            color="danger"
        />
    </section>

    <section class="row">
        {{-- log activity section --}}
        <div class="col-md-6">
            <x-card>
                <x-slot name="title">
                    Statistik Gudang
                </x-slot>
                
                <div class="chart-pie pt-4">
                    <canvas id="myBarChart"></canvas>
                  </div>
            </x-card>
        </div>

        {{-- chart section --}}
        <div class="col-md-6">
            <!-- Area Charts -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Statistik Barang</h6>
                </div>
                <div class="card-body">
                  <div class="chart-pie">
                    <canvas id="myPieChart"></canvas>
                  </div>
                </div>
              </div>
        </div>
    </section>

    <section class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="title">Laporan terakhir</x-slot>

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
        </div>
    </section>

    <x-slot name="script">
        <script>
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';
            
            // Bar Chart Example
            var ctx = document.getElementById("myBarChart");
            var myBarChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: [
                    @foreach ($gudangs as $gudang)
                        '{{ $gudang->nama }}',
                    @endforeach
                ],
                datasets: [{
                  label: "Jumlah",
                  backgroundColor: "#4e73df",
                  hoverBackgroundColor: "#2e59d9",
                  borderColor: "#4e73df",
                  data: [
                    @foreach ($gudangs as $gudang)
                        '{{ $gudang->barangs->sum('jumlah') }}',
                    @endforeach
                  ],
                }],
              },
              options: {
                maintainAspectRatio: false,
                layout: {
                  padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                  }
                },
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'month'
                    },
                    gridLines: {
                      display: false,
                      drawBorder: false
                    },
                    ticks: {
                      maxTicksLimit: 6
                    },
                    maxBarThickness: 25,
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: {{ $jumlah_barang }},
                      maxTicksLimit: 5,
                      padding: 10,
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                        return value;
                      }
                    },
                    gridLines: {
                      color: "rgb(234, 236, 244)",
                      zeroLineColor: "rgb(234, 236, 244)",
                      drawBorder: false,
                      borderDash: [2],
                      zeroLineBorderDash: [2]
                    }
                  }],
                },
                legend: {
                  display: false
                },
                tooltips: {
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                  callbacks: {
                    label: function(tooltipItem, chart) {
                      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                      return datasetLabel + ': ' + tooltipItem.yLabel;
                    }
                  }
                },
              }
            });

            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            // Pie Chart Example
            var ctx = document.getElementById("myPieChart");
            var myPieChart = new Chart(ctx, {
              type: 'doughnut',
              data: {
                labels: [
                    @foreach ($barangs as $barang)
                        '{{ $barang->nama }}',
                    @endforeach
                ],
                datasets: [{
                  data: [
                    @foreach ($barangs as $barang)
                        {{ $barang->jumlah }},
                    @endforeach
                  ],
                  backgroundColor: [
                    @foreach ($barangs as $barang)
                        @php
                            $color = dechex(rand(0x000000, 0xFFFFFF));
                        @endphp
                        '{{ '#'.$color }}',
                    @endforeach
                  ],
                  hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
              },
              options: {
                maintainAspectRatio: false,
                tooltips: {
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                },
                legend: {
                  display: false
                },
                cutoutPercentage: 80,
              },
            });

        </script>
    </x-slot>
</x-app-layout>