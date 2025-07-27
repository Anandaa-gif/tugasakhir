<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Buku</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {

    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .qr-card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            max-width: 500px;
        }

        .qr-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1.5rem 3.5rem rgba(0, 0, 0, 0.15);
        }

        .card-header-custom {
            background: linear-gradient(45deg, #3a7bd5, #00d2ff);
            color: white;
            padding: 1.75rem 1rem;
        }

        .qr-container {
            position: relative;
            padding: 2.5rem;
            background-color: white;
        }

        .qr-box {
            background: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.05);
            display: inline-block;
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .qr-box::after {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border: 2px dashed rgba(58, 123, 213, 0.1);
            border-radius: 1rem;
            z-index: -1;
        }

        .btn-gradient {
            background: linear-gradient(45deg, #3a7bd5, #00d2ff);
            border: none;
            color: white;
            padding: 0.5rem 1.75rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(58, 123, 213, 0.3);
            color: white;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="qr-card mx-auto">
                    <div class="card-header-custom text-center">
                        <h3 class="mb-0"><i class="fas fa-qrcode me-2"></i> Kode QR Buku</h3>
                        <p class="mb-0 mt-2">Scan untuk mengakses informasi buku</p>
                    </div>

                    <div class="qr-container text-center">
                        <div class="qr-box my-2">
                            {!! $qrCode !!}
                        </div>

                        <p class="text-muted mt-4 mb-3">
                            <small>Gunakan aplikasi pembaca QR code untuk memindai</small>
                        </p>

                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">
                            <button class="btn btn-gradient" onclick="window.print()">
                                <i class="fas fa-print me-2"></i> Cetak QR Code
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Optional: Jika tidak ada di layout.tampil --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>