</div>
</div>

<script src="{{ custom_public_url('admin-assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ custom_public_url('admin-assets/js/all.min.js') }}"></script>

<script>
// drawer
const overlay = document.querySelector(".bg_overlay_28");
const openMenu = document.querySelector("#open-menu");
const closeMenu = document.querySelector("#close-menu");
const drawer = document.querySelector("#drawer");

openMenu.addEventListener("click", toggleMenu);
closeMenu.addEventListener("click", toggleMenu);
overlay.addEventListener("click", toggleMenu);

// drawer toggle function
function toggleMenu() {
  console.log("in");
  if (drawer.classList.contains("open")) {
    drawer.classList.remove("open");
    overlay.classList.remove("open");
    console.log("if");
  } else {
    drawer.classList.add("open");
    overlay.classList.add("open");
    console.log("else");
  }
}
</script>
</body>
</html>