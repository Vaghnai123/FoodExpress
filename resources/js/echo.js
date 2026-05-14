import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

if (typeof pusherKey !== 'undefined' && pusherKey !== "" && typeof pusherCluster !== 'undefined' && pusherCluster !== "") {

    window.Echo = new Echo({
        broadcaster: "pusher",
        key: pusherKey,
        cluster: pusherCluster,

        wsHost: `ws-${pusherCluster}.pusher.com`,

        wsPort: 80,
        wssPort: 443,
        forceTLS: true,
        enabledTransports: ["ws", "wss"],
    });

    window.Echo.channel("order-placed").listen(
        "RTOrderPlacedNotificationEvent",
        (e) => {
            console.log("Notification Received:", e);
            let html = `<a href="/admin/orders/${e.orderId}" class="dropdown-item">
                <div class="dropdown-item-icon bg-info text-white">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="dropdown-item-desc">
                    ${e.message}
                    <div class="time">${e.date}</div>
                </div>
            </a>`;

            $(".rt_notification").prepend(html);
            $(".notification_beep").addClass("beep");
        },
    );
} else {
    console.warn("Pusher is not initialized because keys are missing in the Admin Panel.");
}
