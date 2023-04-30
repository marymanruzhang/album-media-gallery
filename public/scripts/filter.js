/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav() {
    document.getElementById("filter").style.width = "250px";
    document.getElementById("content").style.marginRight= "250px";
    document.getElementById("menu").style.marginRight= "500px";
  }

  /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
  function closeNav() {
    document.getElementById("filter").style.width = "0";
    document.getElementById("content").style.marginRight = "0";
    document.getElementById("menu").style.marginRight= "0";
  }
