@extends('admin.layouts.admin-layout')
@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="row">
                <!-- Tổng số khách hàng -->
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Tổng số khách hàng</p>
                                        <h4 class="card-title">{{ $totalCustomers }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tổng số người đăng ký -->
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Tổng số người đăng ký</p>
                                        <h4 class="card-title">{{ $totalSubscribers }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doanh thu -->
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-luggage-cart"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Doanh thu</p>
                                        <h4 class="card-title">{{ number_format($totalSales, 0, ',', '.') }} VNĐ</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Số lượng đơn hàng -->
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                        <i class="far fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Số lượng đơn hàng</p>
                                        <h4 class="card-title">{{ $totalOrders }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Thống kê</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="min-height: 375px">
                            <canvas id="statisticsChart"></canvas>
                        </div>
                        <div id="myChartLegend"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-round">
                    <div class="card-body pb-0">
                        <div class="h1 fw-bold float-end text-primary">+5%</div>
                        <h2 class="mb-2">{{ $onlineUsers }}</h2> <!-- Số người dùng online -->
                        <p class="text-muted">Người dùng đang online</p>
                        <div class="pull-in sparkline-fix">
                            <div id="lineChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-round">
                    <div class="card-body">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Khách hàng mới</div>
                            <div class="card-tools">
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-clean me-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Hành động</a>
                                        <a class="dropdown-item" href="#">Hành động khác</a>
                                        <a class="dropdown-item" href="#">Thứ gì đó ở đây</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-list py-4">
                            @foreach ($newCustomers as $customer)
                                <div class="item-list">
                                    <div class="avatar">
            <span class="avatar-title rounded-circle border border-white bg-primary">
                {{ strtoupper(substr($customer->name, 0, 1)) }}
            </span>
                                    </div>
                                    <div class="info-user ms-3">
                                        <div class="username">{{ $customer->name }}</div>
                                        <div class="status">{{ $customer->email }}</div>
                                    </div>
                                    <button class="btn btn-icon btn-link op-8 me-1">
                                        <i class="far fa-envelope"></i>
                                    </button>
                                    <button class="btn btn-icon btn-link btn-danger op-8">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Lịch sử giao dịch</div>
                            <div class="card-tools">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-icon btn-clean me-0"
                                        type="button"
                                        id="dropdownMenuButton"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Hành động</a>
                                        <a class="dropdown-item" href="#">Hành động khác</a>
                                        <a class="dropdown-item" href="#">Một cái gì đó ở đây</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <!-- Bảng lịch sử giao dịch -->
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Số đơn hàng</th>
                                    <th scope="col" class="text-end">Ngày & Giờ</th>
                                    <th scope="col" class="text-end">Số tiền</th>
                                    <th scope="col" class="text-end">Trạng thái thanh toán</th>
                                    <th scope="col" class="text-end">Phương thức thanh toán</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <th scope="row">
                                            <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            Đơn hàng #{{ $order->id }}
                                        </th>
                                        <td class="text-end">{{ $order->created_at->format('d M, Y, h:i A') }}</td>
                                        <td class="text-end">{{ number_format($order->final_total, 0) }} VND</td>
                                        <td class="text-end">
                                <span class="badge badge-{{ $order->payment_status == 'completed' ? 'success' : 'danger' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                                        </td>
                                        <td class="text-end">
                                            {{ ucfirst($order->payment_method) }}
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
    </div>
@endsection

@section('js')
    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#basic-datatables").DataTable({});



            // Add Row
            $("#add-row").DataTable({
                pageLength: 5,
            });

            var action =
                '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

            $("#addRowButton").click(function () {
                $("#add-row")
                    .dataTable()
                    .fnAddData([
                        $("#addName").val(),
                        $("#addPosition").val(),
                        $("#addOffice").val(),
                        action,
                    ]);
                $("#addRowModal").modal("hide");
            });
        });
    </script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{asset('admin/assets/js/setting-demo.js')}}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("{{ route('statistics.data') }}")
                .then(response => response.json())
                .then(data => {
                    updateChart(data);
                });
        });

        function updateChart(data) {
            var ctx = document.getElementById("statisticsChart").getContext("2d");

            var statisticsChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [
                        {
                            label: "Doanh thu",
                            borderColor: "#f3545d",
                            backgroundColor: "rgba(243, 84, 93, 0.4)",
                            data: data.revenue,
                            fill: true,
                        },
                        {
                            label: "Số đơn hàng",
                            borderColor: "#fdaf4b",
                            backgroundColor: "rgba(253, 175, 75, 0.4)",
                            data: data.totalOrders,
                            fill: true,
                        },
                        {
                            label: "Số phiếu nhập",
                            borderColor: "#1d8cf8",
                            backgroundColor: "rgba(29, 140, 248, 0.4)",
                            data: data.totalPurchases,
                            fill: true,
                        },
                        {
                            label: "Sản phẩm bán ra",
                            borderColor: "#00c09d",
                            backgroundColor: "rgba(0, 192, 157, 0.4)",
                            data: data.totalSold,
                            fill: true,
                        },
                        {
                            label: "Sản phẩm nhập vào",
                            borderColor: "#a55eea",
                            backgroundColor: "rgba(165, 94, 234, 0.4)",
                            data: data.totalPurchased,
                            fill: true,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    </script>
@endsection
