// $(document).ready(function() {

//     // Fakes the loading setting a timeout
//       setTimeout(function() {
//           $('body').addClass('loaded');
//       }, 3500);

//   });
// $(window).on("load", function () {
//     $("body").addClass('loaded');
// });
window.onload = function(){
    document.querySelector(".loader").style.display = "none";
}
window.scrollTo({
    top: 15,
    left: 15,
    behaviour: 'smooth'
})
// const wait = (delay = 0) => new Promise(resolve => setTimeout(resolve, delay));

// const setVisible = (elementOrSelector, visible) =>
// (typeof elementOrSelector === 'string'
//     ? document.querySelector(elementOrSelector)
//     : elementOrSelector
// ).style.display = visible ? 'flex' : 'none';
// setVisible('.loader', true);

// document.addEventListener('DOMContentLoaded', () =>
//     wait(1500).then(() => {
//         setVisible('.loader', false);
//     })
// );
