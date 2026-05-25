<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sakura - Staff Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <style>
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .toast {
            min-width: 300px;
        }
    </style>
</head>
<body style="background-color: #fdf4f8;">
    <!-- Toast Container -->
    <div class="toast-container"></div>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showToast(message, type = 'success') {
            const toastHTML = `
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'warning'} text-white">
                        <strong class="me-auto">
                            <i class="bi ${type === 'success' ? 'bi-check-circle' : type === 'error' ? 'bi-x-circle' : 'bi-info-circle'}"></i>
                            ${type === 'success' ? 'Success' : type === 'error' ? 'Error' : 'Info'}
                        </strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            const container = document.querySelector('.toast-container');
            container.insertAdjacentHTML('beforeend', toastHTML);
            const toastElement = container.lastElementChild;
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            setTimeout(() => toastElement.remove(), 5000);
        }

        // Auto-show toast if flash messages exist
        document.addEventListener('DOMContentLoaded', function() {
            @if ($message = Session::get('success'))
                showToast('{{ $message }}', 'success');
            @endif
            @if ($message = Session::get('error'))
                showToast('{{ $message }}', 'error');
            @endif
        });
    </script>
</body>
</html>