<div class="tab-pane fade" id="v-pills-reservation" role="tabpanel" aria-labelledby="v-pills-reservation-tab">
    <div class="fp_dashboard_body">
        <h3 class="text-capitalize mb-4 pb-3"
            style="font-weight: 700; color: #2b2b2b; font-size: 20px; border-bottom: 2px solid #d19106;">
            Reservations
        </h3>

        @if ($reservations->count() > 0)
            <div class="fp_dashboard_order">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr class="t_header">
                                <th>No</th>
                                <th>Reservation Id</th>
                                <th>Date/Time</th>
                                <th>Person</th>
                                <th>Status</th>
                            </tr>
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td>
                                        <h5>{{ ++$loop->index }}</h5>
                                    </td>
                                    <td>
                                        {{ $reservation->reservation_id }}
                                    </td>
                                    <td>
                                        {{ $reservation->date }} | {{ $reservation->time }}
                                    </td>
                                    <td>
                                        {{ $reservation->persons }}
                                    </td>
                                    <td>
                                        @if ($reservation->status === 'pending')
                                            <span class="status-badge status-pending">Pending</span>
                                        @elseif ($reservation->status === 'approved')
                                            <span class="status-badge status-in-process">Approve</span>
                                        @elseif ($reservation->status === 'complete')
                                            <span class="status-badge status-delivered">Complete</span>
                                        @elseif ($reservation->status === 'cancel')
                                            <span class="status-badge status-declined">Cancel</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($reservations->hasPages())
                <div class="fp__pagination mt_40 mb_40">
                    <div class="row">
                        <div class="col-12">
                            {{ $reservations->links() }}
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-check" style="font-size: 60px; color: #d1d5db; margin-bottom: 20px;"></i>
                <h5 style="color: #6c757d; font-size: 18px; margin-bottom: 10px;">You haven't made any reservations yet.
                </h5>
                <p style="color: #8c98a4; font-size: 15px; margin: 0;">Book a table and enjoy a great dining experience
                    with us!</p>
            </div>
        @endif
    </div>
</div>
