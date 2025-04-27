import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Fungsi fetchNotif global
// window.fetchNotif = function () {
//     console.log("[fetchNotif] Dipanggil!");
//     const notifCount = document.getElementById("notif-count");
//     const notifList = document.getElementById("notif-list");

//     // Kalau elemen tidak ada, hentikan
//     if (!notifCount || !notifList) return;

//     fetch("/notifikasi/fetch")
//         .then((res) => res.json())
//         .then((data) => {
//             notifList.innerHTML = "";
//             let unread = 0;
//             const maxDisplay = 3;

//             const unreadNotifs = data.filter((notif) => !notif.is_read);
//             unread = unreadNotifs.length;

//             unreadNotifs.slice(0, maxDisplay).forEach((notif) => {
//                 notifList.innerHTML += `
//                     <li class="list-group-item border-0 align-items-start">
//                         <a href="/konseling" class="d-flex text-dark text-decoration-none">
//                             <div class="avatar bg-success mr-3">
//                                 <span class="avatar-content"><i data-feather="bell"></i></span>
//                             </div>
//                             <div>
//                                 <h6 class="text-bold mb-1">${notif.title}</h6>
//                                 <p class="text-xs mb-0">${notif.body}</p>
//                             </div>
//                         </a>
//                     </li>
//                 `;
//             });

//             if (unread > maxDisplay) {
//                 notifList.innerHTML += `
//                     <li class="list-group-item text-center border-top">
//                         <a href="/konseling" class="text-primary font-weight-bold">
//                             Lihat Semua Konseling
//                         </a>
//                     </li>
//                 `;
//             }

//             notifCount.textContent = unread;
//             feather.replace();
//         });
// };
