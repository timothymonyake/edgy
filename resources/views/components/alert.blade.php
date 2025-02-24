<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof Swal === 'undefined') {
            console.error('SweetAlert2 (Swal) is not loaded!');
            return;
        }

        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        // Attach function to window so it can be called from anywhere
        window.showToast = function(message, type = 'info') {
            if (typeof Toast.fire !== 'function') {
                console.error('SweetAlert2 is not properly initialized.');
                return;
            }
            Toast.fire({
                icon: type,
                title: message
            });
        };

        // Auto trigger toast from session flash messages
        @if (session('success'))
            showToast("{{ session('success') }}", "success");
        @elseif (session('error'))
            showToast("{{ session('error') }}", "error");
        @elseif (session('warning'))
            showToast("{{ session('warning') }}", "warning");
        @elseif (session('info'))
            showToast("{{ session('info') }}", "info");
        @endif
    });
</script>
