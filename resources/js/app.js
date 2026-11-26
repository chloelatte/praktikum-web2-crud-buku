import './bootstrap';

// Mengambil ID user yang sedang login
const authUserId = document.querySelector(
    'meta[name="auth-user-id"]'
)?.content;

if (authUserId) {

    // Berlangganan ke private channel user
    const channel = window.Echo.private(
        `App.Models.User.${authUserId}`
    );

    // Mendengarkan Broadcast Notificaftion
    channel.notification((notification) => {
        console.log('Notifikasi realtime diterima:', notification);

        const container = document.getElementById(
            'notification-toast-container'
        );

        const toast = document.createElement('div');
        toast.className = 'notification-toast';

        const title = document.createElement('h6');
        title.textContent = 'Pesanan Berhasil!';

        const message = document.createElement('p');
        message.textContent = notification.pesan;

        const order = document.createElement('p');
        order.textContent = 'Nomor Pesanan: ' + notification.nomor_pesanan;

        const total = document.createElement('p');
        total.textContent = 'Total: Rp ' +
            Number(notification.total).toLocaleString('id-ID');

        toast.appendChild(title);
        toast.appendChild(message);
        toast.appendChild(order);
        toast.appendChild(total);

        container.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 5000);
    });

    // Mendengarkan Event PesananDibuat
    channel.listen('.pesanan.dibuat', (event) => {
        console.log('Event PesananDibuat diterima:', event);
    });

    // Berlangganan ke Presence Channel
    window.Echo.join('chat')

    .here((users) => {
        console.log('Pengguna yang sedang online:', users);
    })

    .joining((user) => {
        console.log(user.name + ' bergabung ke chat.');
    })

    .leaving((user) => {
        console.log(user.name + ' meninggalkan chat.');
    });
}

// Berlangganan ke Public Channel
window.Echo.channel('pengumuman')
    .listen('.pengumuman.baru', (event) => {
        console.log('Pengumuman baru diterima:', event);
    });