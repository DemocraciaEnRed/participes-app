<footer class="footer-three footer-grey p-top-20">

  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="footer-bottom--content">


            <a href="" class="footer-logo">
              <img style="max-height: 60px;" class="m-right-20 m-left-20" src="https://zenprospect-production.s3.amazonaws.com/uploads/pictures/5c2e26d9a3ae6122026ce0e9/picture" alt="">
              <img style="max-height: 40px;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRoCGcEqSL5Mij2ylyBgTbyehAFifrZkiJC0KyIsUDoiG8IGnRJ&s" alt="">
            </a>

            <div class=" lng-list">

              <img style="max-height: 40px;" class="" src="https://namati.org/wp-content/uploads/2019/02/logo-DER_negro-3-300x120.png" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- ends: .footer-bottom -->
</footer><!-- ends: .footer -->



<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0C5etf1GVmL_ldVAichWwFFVcDfa1y_c"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
  new Chart(document.getElementById("doughnut-chart"), {
    type: 'doughnut',
    data: {
      labels: ["En progreso", "Alcanzadas", "Demoradas", "Inactivo"],
      datasets: [{
        label: "Validaciones",
        backgroundColor: ["#fa8b0c", "#32cc6f", "#f16078", "#272b41"],
        data: [2, 2, 2, 2]
      }]
    },
    options: {
      legend: {
        display: false
      },
      tooltips: {
        enabled: false
      },
      title: {
        display: false,
        text: 'Predicted world population (millions) in 2050'
      }
    }
  });

  new Chart(document.getElementById("doughnut-chart2"), {
    type: 'doughnut',
    data: {
      labels: ["En progreso", "Alcanzadas", "Demoradas", "Inactivo"],
      datasets: [{
        label: "Validaciones",
        backgroundColor: ["#fa8b0c", "#32cc6f", "#f16078", "#272b41"],
        data: [2, 4, 2, 1]
      }]
    },
    options: {
      legend: {
        display: false
      },
      tooltips: {
        enabled: false
      },
      title: {
        display: false,
        text: 'Predicted world population (millions) in 2050'
      }
    }
  });

  new Chart(document.getElementById("doughnut-chart3"), {
    type: 'doughnut',
    data: {
      labels: ["En progreso", "Alcanzadas", "Demoradas", "Inactivo"],
      datasets: [{
        label: "Validaciones",
        backgroundColor: ["#fa8b0c", "#32cc6f", "#f16078", "#272b41"],
        data: [1, 7, 5, 2]
      }]
    },
    options: {
      legend: {
        display: false
      },
      tooltips: {
        enabled: false
      },
      title: {
        display: false,
        text: 'Predicted world population (millions) in 2050'
      }
    }
  });
</script>
<script>
    document.addEventListener(
        "DOMContentLoaded",
        () => {
            //Basic Accordion
            const basic = new HandyCollapse();
            //Nested
            const nested = new HandyCollapse({
                nameSpace: "nested",
                closeOthers: false
            });
            //Callback
            const callback = new HandyCollapse({
                nameSpace: "callback",
                closeOthers: false,
                onSlideStart: (isOpen, contentID) => {
                    console.log(isOpen);
                    const buttonEl = document.querySelector(`[data-callback-control='${contentID}']`);
                    if (!buttonEl) return;
                    if (isOpen) {
                        buttonEl.textContent = "Opened " + contentID;
                    } else {
                        buttonEl.textContent = "Closed " + contentID;
                    }
                }
            });
            //Callback
            const tab = new HandyCollapse({
                nameSpace: "tab",
                closeOthers: true,
                isAnimation: false
            });
        },
        false
    );
</script>
<!-- inject:js-->
<script src="theme_assets/js/handy-collapse.js"></script>
<script src="vendor_assets/js/jquery/jquery-1.12.3.js"></script>
<script src="vendor_assets/js/bootstrap/popper.js"></script>
<script src="vendor_assets/js/bootstrap/bootstrap.min.js"></script>
<script src="vendor_assets/js/jquery-ui.min.js"></script>
<script src="vendor_assets/js/jquery.barrating.min.js"></script>
<script src="vendor_assets/js/jquery.counterup.min.js"></script>
<script src="vendor_assets/js/jquery.magnific-popup.min.js"></script>
<script src="vendor_assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="vendor_assets/js/jquery.waypoints.min.js"></script>
<script src="vendor_assets/js/masonry.pkgd.min.js"></script>
<script src="vendor_assets/js/owl.carousel.min.js"></script>
<script src="vendor_assets/js/select2.full.min.js"></script>
<script src="vendor_assets/js/slick.min.js"></script>


<!-- endinject-->
</body>

</html>
