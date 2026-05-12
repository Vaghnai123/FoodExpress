@extends('admin.layouts.master')

@section('content')
    <section class="section">

        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-comment-dots" style="color: #6777ef; margin-right: 10px;"></i> Messages
            </h1>
        </div>

        <div class="section-body">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card" style="height: 70vh">
                        <div class="card-header">
                            <h4>Conversations</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach ($senders as $sender)
                                    @php
                                        $chatUser = \App\Models\User::find($sender->sender_id);

                                        $adminIds = \App\Models\User::where('role', 'admin')->pluck('id')->toArray();

                                        $unseenMessages = \App\Models\Chat::where('sender_id', $chatUser->id)
                                            ->whereIn('receiver_id', $adminIds)
                                            ->where('seen', 0)
                                            ->count();
                                    @endphp
                                    <li class="media fp_chat_user" data-name="{{ $chatUser->name }}"
                                        data-user="{{ $chatUser->id }}" style="cursor: pointer">
                                        <img alt="image" class="mr-3 rounded-circle " width="50"
                                            src="{{ $chatUser->avatar ? asset($chatUser->avatar) : asset('frontend/images/default-avatar.jpg') }}"
                                            style="width: 50px;height: 50px; object-fit: cover;">
                                        <div class="media-body">
                                            <div class="mt-0 mb-1 font-weight-bold">{{ $chatUser->name }}</div>
                                            <div class="text-warning text-small font-600-bold got_new_message">
                                                @if ($unseenMessages > 0)
                                                    <i class="beep"></i>new message
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-9">

                    <div class="card chat-box" id="chat-placeholder"
                        style="height: 70vh; display: flex; flex-direction: column; justify-content: center; align-items: center; background-color: #fdfdfd;">
                        <i class="fas fa-comments" style="font-size: 5rem; color: #e4e6fc; margin-bottom: 20px;"></i>
                        <h4 style="color: #34395e; font-weight: 800; font-size: 19px;">Select a conversation</h4>
                        <p style="color: #6c757d; font-weight: 700; font-size: 13px;">Select User To View Conversation.</p>
                    </div>

                    <div class="card chat-box d-none" id="mychatbox" data-inbox="" style="height: 70vh">
                        <div class="card-header">
                            <h4 id="chat_header"></h4>
                        </div>
                        <div class="card-body chat-content">

                        </div>

                        <div class="card-footer chat-form">
                            <form id="chat-form">
                                @csrf
                                <input type="text" class="form-control fp_send_message" placeholder="Type a message"
                                    name="message">
                                <input type="hidden" name="receiver_id" id="receiver_id" value="">
                                <input type="hidden" name="msg_temp_id" class="msg_temp_id" value="">

                                <button class="btn btn-primary">
                                    <i class="far fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            var userId = "{{ auth()->user()->id }}"
            var defaultAvatar = @json(asset('frontend/images/default-avatar.jpg'));
            var authAvatar = @json(auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('frontend/images/default-avatar.jpg'));
            $('#receiver_id').val("");

            function scrollToBootom() {
                let chatContent = $('.chat-content');
                chatContent.scrollTop(chatContent.prop("scrollHeight"));
            }

            // fetch conversations
            $('.fp_chat_user').on('click', function() {
                let senderId = $(this).data('user');
                let senderName = $(this).data('name')
                let clickedElemnt = $(this);

                $('#chat-placeholder').addClass('d-none');
                $('#mychatbox').removeClass('d-none');

                $('#mychatbox').attr('data-inbox', senderId);
                $('#receiver_id').val(senderId);
                $.ajax({
                    method: 'GET',
                    url: '{{ route('admin.chat.get-conversation', ':senderId') }}'.replace(
                        ":senderId", senderId),
                    beforeSend: function() {
                        $('.chat-content').empty();
                        $('#chat_header').text("Chat With " + senderName);
                    },
                    success: function(response) {
                        $('.chat-content').empty();

                        $.each(response, function(index, message) {
                            let avatarPath = message.sender.avatar;
                            let avatarUrl = defaultAvatar
                            if (avatarPath) {
                                avatarUrl = avatarPath.startsWith('http') ?
                                    avatarPath :
                                    "{{ asset('/') }}" + avatarPath.replace(/^\/+/,
                                        '');
                            }
                            let html = `
                            <div class="chat-item ${message.sender_id == userId ? "chat-right" : "chat-left"} " style=""><img style="width:50px;height:50px;object-fit:cover;" src="${avatarUrl}"><div class="chat-details"><div class="chat-text">${message.message}</div></div></div>
                            `
                            $('.chat-content').append(html);

                        })

                        clickedElemnt.find(".got_new_message").html("")

                        scrollToBootom()

                    },
                    error: function(xhr, status, error) {

                    }

                })
            })

            // send message
            $('#chat-form').on('submit', function(e) {
                e.preventDefault();
                var msgId = Math.floor(Math.random() * (1 - 10000 + 1)) + 10000;
                $('.msg_temp_id').val(msgId)

                let formData = $(this).serialize();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.chat.send-message') }}",
                    data: formData,
                    beforeSend: function() {
                        let message = $('.fp_send_message').val();
                        let html = `
                            <div class="chat-item chat-right" style=""><img src="${authAvatar}"><div class="chat-details"><div class="chat-text">${message}</div><div class="chat-time ${msgId}">sending...</div></div></div>
                            `

                        $('.chat-content').append(html);
                        $('.fp_send_message').val("");
                        scrollToBootom()

                        // remove beep notification

                        $(".fp_chat_user").each(function() {
                            let senderId = $(this).data('user');

                            if ($('#mychatbox').attr('data-inbox') == senderId) {
                                $(this).find(".got_new_message").html("");
                            }
                        })
                    },
                    success: function(response) {
                        if ($('.msg_temp_id').val() == response.msgId) {
                            console.log($('.' + msgId))
                            $('.' + msgId).remove();
                        }
                    },
                    error: function(xhr, status, error) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value);
                        })
                    }
                })
            })
        })
    </script>
@endpush
