<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Blank</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('/') }}sbadmin2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('/') }}sbadmin2/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        /* Use Poppins as the app font */
        body, h1, h2, h3, h4, h5, h6, .navbar, .sidebar, .card {
            font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        /* Center table header text across the app for Bootstrap tables */
        .table thead th {
            text-align: center;
            vertical-align: middle;
        }
        
        /* Page transition effects */
        .page-transition {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        
        .page-transition.fade-in {
            opacity: 1;
        }
        
        .page-transition.fade-out {
            opacity: 0;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Remove top spacing to eliminate gap */
        #content {
            margin-top: 0;
            padding-top: 0;
        }

        /* Adjust wrapper spacing */
        #wrapper {
            padding-top: 0;
        }

        /* Adjust page top margin */
        #page-top {
            padding-top: 0;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
      <x-sidebar />
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
             <x-topbar />
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
               @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
           <x-footer />
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                    <div class="modal-body">Pilih "Keluar" di bawah jika Anda siap mengakhiri sesi saat ini.</div>
                    <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <a class="btn btn-primary" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/') }}sbadmin2/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('/') }}sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('/') }}sbadmin2/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('/') }}sbadmin2/js/sb-admin-2.min.js"></script>

    <!-- Page transition script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pageContent = document.querySelector('#content');
            
            // Check if we're transitioning from another page
            const isTransitioning = sessionStorage.getItem('pageTransition');
            
            if (isTransitioning) {
                // Coming from a transition - start invisible and fade in
                if (pageContent) {
                    pageContent.style.opacity = '0';
                    pageContent.style.transition = 'opacity 0.3s ease-in-out';
                    sessionStorage.removeItem('pageTransition'); // Clean up
                    
                    // Trigger reflow and then fade in
                    void pageContent.offsetWidth; // Trigger reflow
                    setTimeout(() => {
                        pageContent.style.opacity = '1';
                    }, 10);
                }
            }
            // If not transitioning, the page shows normally without animation
            
            // Handle link clicks for smooth transitions
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');

                // Skip transition for logout links (they handle form submission)
                if (link && (link.getAttribute('onclick') && link.getAttribute('onclick').includes('logout-form') || link.href.includes('/logout'))) {
                    return; // Allow normal logout behavior
                }

                if (link && !link.hasAttribute('target') && !link.href.startsWith('mailto:') && !link.href.startsWith('tel:')) {
                    e.preventDefault();

                    // Set transition flag
                    sessionStorage.setItem('pageTransition', 'true');

                    // Fade out current page
                    if (pageContent) {
                        pageContent.style.transition = 'opacity 0.3s ease-in-out';
                        pageContent.style.opacity = '0';

                        setTimeout(() => {
                            window.location.href = link.href;
                        }, 300); // Match the CSS transition duration
                    } else {
                        window.location.href = link.href;
                    }
                }
            });
            
            // Handle form submissions for smooth transitions
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    // Skip transition for logout forms
                    if (form.id === 'logout-form' || form.action?.includes('/logout')) {
                        return; // Allow normal logout behavior
                    }
                    
                    if (!form.hasAttribute('target')) {
                        e.preventDefault();

                        // Set transition flag
                        sessionStorage.setItem('pageTransition', 'true');

                        // Fade out current page
                        if (pageContent) {
                            pageContent.style.transition = 'opacity 0.3s ease-in-out';
                            pageContent.style.opacity = '0';

                            setTimeout(() => {
                                form.submit();
                            }, 300); // Match the CSS transition duration
                        } else {
                            form.submit();
                        }
                    }
                });
            });
        });
    </script>

    @yield('scripts')

</body>
</html>
