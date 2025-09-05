@if ($selected_application)
    <div class="py-3 px-5 space-y-5 border border-gray-300 rounded-md h-full bg-gray-100 flex flex-col relative" x-data="chattingFunction" x-init="initialize">
        <div x-show="showPopupEdit" x-cloak class="top-0 left-0 bottom-0 right-0 absolute z-20 bg-gray-50/50 flex justify-center items-center">
            <div class="bg-white border border-gray-300 rounded-md w-1/2 h-fit p-3">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="mb-2">Edit this Comment</h2>
                    <div class="p-2 bg-gray-50 hover:bg-gray-100 cursor-pointer rounded-full" x-on:click="showPopupEdit = !showPopupEdit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 32 32"><path fill="currentColor" d="M16 2C8.2 2 2 8.2 2 16s6.2 14 14 14s14-6.2 14-14S23.8 2 16 2m0 26C9.4 28 4 22.6 4 16S9.4 4 16 4s12 5.4 12 12s-5.4 12-12 12"/><path fill="currentColor" d="M21.4 23L16 17.6L10.6 23L9 21.4l5.4-5.4L9 10.6L10.6 9l5.4 5.4L21.4 9l1.6 1.6l-5.4 5.4l5.4 5.4z"/></svg>
                    </div>
                </div>
                <form x-on:submit.prevent="sendEditedMessage(selectedForEdit.id)" class="flex gap-x-2">
                    <input type="text" id="edit-message" x-model="selectedForEdit.message" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Edit Message for recruiter"  />
                    <template x-if="sending" x-cloak>
                        <div class="inline-flex items-center py-2 px-7 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><circle cx="18" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="6" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>
                        </div>
                    </template>
                    <template x-if="!sending" x-cloak>
                        <button class="inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="16" height="16" viewBox="0 0 16 16"><g fill="currentColor"><path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855a.75.75 0 0 0-.124 1.329l4.995 3.178l1.531 2.406a.5.5 0 0 0 .844-.536L6.637 10.07l7.494-7.494l-1.895 4.738a.5.5 0 1 0 .928.372zm-2.54 1.183L5.93 9.363L1.591 6.602z"/><path d="M16 12.5a3.5 3.5 0 1 1-7 0a3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5"/></g></svg>Edit
                        </button>
                    </template>
                </form>
            </div>
        </div>
        <x-chat.chat-info-document :selected-application="$selected_application"/>
        {{-- All displayed messages --}}
        <div class="h-full overflow-y-auto space-y-3 mt-auto">
            <template x-if="initialLoadLoading" x-cloak>
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto" width="48" height="48" viewBox="0 0 24 24"><circle cx="18" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="6" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>
                    <p class="text-gray-500 text-sm">Loading... </p>
                </div>
            </template>
            <template x-for="(message, idx) in messages" :key="message.id">
                <div>
                    <template x-if="message.receiver_id == '{{ Auth::user()->id }}'">
                        <div class="flex items-start gap-2.5">
                            <template x-if="minimizeContent(messages, idx)">
                                <img class="w-8 h-8 rounded-full" :src="message.user_avatar" alt="Jese image">
                            </template>
                            <template x-if="!minimizeContent(messages, idx)">
                                <span class="w-8"></span>
                            </template>
                            <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-white rounded-e-xl rounded-es-xl">
                                <template x-if="message.message_id">
                                    <div class="border border-gray-400 rounded-md p-2 bg-gray-200 mb-2">
                                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                            <span class="text-sm font-semibold text-gray-900" x-text="loadReplyMessage(message.message_id).user_name"></span>
                                            <span class="text-sm font-normal text-gray-500" x-text="loadReplyMessage(message.message_id).created_at">11:46</span>
                                        </div>
                                        <template x-if="!loadReplyMessage(message.message_id).deleted_at">
                                            <p class="text-sm font-normal pt-2.5 text-gray-900" x-text="loadReplyMessage(message.message_id).message"></p>
                                        </template>
                                        <template x-if="loadReplyMessage(message.message_id).deleted_at">
                                            <p class="text-sm font-normal pt-2.5 text-gray-700 italic">The Message has been deleted</p>
                                        </template>
                                        
                                        <template x-if="loadReplyMessage(message.message_id).is_edited && !loadReplyMessage(message.message_id).deleted_at">
                                            <p class="text-gray-500 text-xs pt-3">(Edited on <span x-text="loadReplyMessage(message.message_id).updated_at"></span>)</p>
                                        </template>
                                    </div>
                                </template>
                                <div>
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <span class="text-sm font-semibold text-gray-900" x-text="message.user_name"></span>
                                        <span class="text-sm font-normal text-gray-500" x-text="message.created_at">11:46</span>
                                    </div>
                                    <template x-if="!message.deleted_at">
                                        <p class="text-sm font-normal pt-2.5 text-gray-900" x-text="message.message"></p>
                                    </template>
                                    <template x-if="message.deleted_at">
                                        <p class="text-sm font-normal pt-2.5 text-gray-700 italic">The Message has been deleted</p>
                                    </template>
                                    
                                    <template x-if="message.is_edited && !message.deleted_at">
                                        <p class="text-gray-500 text-xs pt-3">(Edited on <span x-text="message.updated_at"></span>)</p>
                                    </template>
                                </div>
                            </div>
                            <template x-if="!closedChat">
                                <div class="relative inline-flex self-center items-center">
                                    <button x-on:click="openChatMenu = (openChatMenu === `drop-${message.id}`) ? '' : $nextTick(() => openChatMenu = `drop-${message.id}`)" class="flex my-auto p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50" type="button">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                        </svg>
                                    </button>
                                    <div x-show="openChatMenu == `drop-${message.id}`" @click.outside="openChatMenu = ''" class="z-10 left-0 top-10 absolute bg-white divide-gray-100 rounded-lg shadow-sm w-40">
                                        <ul class="py-2 text-sm text-gray-700 ">
                                            <li x-on:click="doReplyMessage(message.id)">
                                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Reply</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="message.sender_id == '{{ Auth::user()->id }}'">
                        <div class="flex items-start gap-2.5 flex-row-reverse">
                            <template x-if="minimizeContent(messages, idx)">
                                <img class="w-8 h-8 rounded-full" :src="message.user_avatar" alt="Jese image">
                            </template>
                            <template x-if="!minimizeContent(messages, idx)">
                                <span class="w-8"></span>
                            </template>

                            <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-purple-200 rounded-s-xl rounded-ee-xl">
                                <template x-if="message.message_id">
                                    <div class="border border-purple-500 rounded-md p-2 bg-purple-300 mb-2">
                                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                            <span class="text-sm font-semibold text-gray-900" x-text="loadReplyMessage(message.message_id).user_name"></span>
                                            <span class="text-sm font-normal text-gray-500" x-text="loadReplyMessage(message.message_id).created_at"></span>
                                        </div>
                                        <template x-if="!loadReplyMessage(message.message_id).deleted_at">
                                            <p class="text-sm font-normal pt-2.5 text-gray-900" x-text="loadReplyMessage(message.message_id).message"></p>
                                        </template>
                                        <template x-if="loadReplyMessage(message.message_id).deleted_at">
                                            <p class="text-sm font-normal pt-2.5 text-gray-500 italic">The Message has been deleted</p>
                                        </template>

                                        <template x-if="loadReplyMessage(message.message_id).is_edited && !loadReplyMessage(message.message_id).deleted_at">
                                            <p class="text-gray-500 text-xs pt-3">(Edited on <span x-text="loadReplyMessage(message.message_id).updated_at"></span>)</p>
                                        </template>
                                    </div>
                                </template>
                                
                                <div>
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <span class="text-sm font-semibold text-gray-900" x-text="message.user_name"></span>
                                        <span class="text-sm font-normal text-gray-500" x-text="message.created_at"></span>
                                    </div>
                                    <template x-if="!message.deleted_at">
                                        <p class="text-sm font-normal pt-2.5 text-gray-900" x-text="message.message"></p>
                                    </template>
                                    <template x-if="message.deleted_at">
                                        <p class="text-sm font-normal pt-2.5 text-gray-500 italic">The Message has been deleted</p>
                                    </template>

                                    <template x-if="message.is_edited && !message.deleted_at">
                                        <p class="text-gray-500 text-xs pt-3">(Edited on <span x-text="message.updated_at"></span>)</p>
                                    </template>
                                </div>
                            </div>
                            <template x-if="!closedChat">
                                <div class="relative inline-flex self-center items-center">
                                    <button x-on:click="openChatMenu = (openChatMenu === `drop-${message.id}`) ? '' : $nextTick(() => openChatMenu = `drop-${message.id}`)" class="flex my-auto p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50" type="button">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                        </svg>
                                    </button>
                                    <div x-show="openChatMenu == `drop-${message.id}`" @click.outside="openChatMenu = ''" :class="idx >= messages.length-1 ? 'bottom-10' : 'top-10'" class="z-10 right-0 absolute bg-white divide-gray-100 rounded-lg shadow-sm w-40">
                                        <ul class="py-2 text-sm text-gray-700 ">
                                            <li x-on:click="doReplyMessage(message.id)">
                                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Reply</a>
                                            </li>
                                            <template x-if="!message.deleted_at">
                                                <li x-on:click="editMessage(message.id)">
                                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Edit</a>
                                                </li>
                                                <li x-on:click="deletedMessage(message.id)">
                                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Delete</a>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
            {{-- end Messages --}}

            <div class="inline-flex items-center justify-center w-full relative" x-show="initialLoadErrorValue" x-cloak>
                <hr class="border-t border-gray-300 m-5 w-full">
                <p class="absolute bg-gray-100 px-3 text-center text-gray-600 text-md" x-text="initialLoadErrorValue"></p>
            </div>
        </div>
        {{-- if closedChat true --}}
        @if ($selected_application["application"]->status == "rejected" && !Auth::user()->is_recruiter)
            <div class="bg-red-200 w-full p-2 text-center border border-red-500">
                <h3 class="py-3 text-red-600">Sorry, Application was Rejected</h3>
            </div>
        @endif

        {{-- Form for Sent and Reply Message --}}
        <template x-if="!showPopupEdit && !closedChat">
            <div>
                <template x-if="replyMessage && Object.keys(replyMessage).length > 0">
                    <div class="bg-white rounded-lg p-3 mb-2">
                        <div class="border border-gray-300 p-3 rounded-md bg-gray-50">
                            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                <div>
                                    <span class="text-sm font-semibold text-gray-900" x-text="replyMessage.user_name"></span>
                                    <span class="text-sm font-normal text-gray-500" x-text="replyMessage.created_at"></span>
                                </div>
                                <template x-if="!sending">
                                    <div x-on:click="removeReplyMessage" class="p-2 bg-gray-50 hover:bg-gray-100 cursor-pointer rounded-full" x-on:click="showPopupEdit = !showPopupEdit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 32 32"><path fill="currentColor" d="M16 2C8.2 2 2 8.2 2 16s6.2 14 14 14s14-6.2 14-14S23.8 2 16 2m0 26C9.4 28 4 22.6 4 16S9.4 4 16 4s12 5.4 12 12s-5.4 12-12 12"/><path fill="currentColor" d="M21.4 23L16 17.6L10.6 23L9 21.4l5.4-5.4L9 10.6L10.6 9l5.4 5.4L21.4 9l1.6 1.6l-5.4 5.4l5.4 5.4z"/></svg>
                                    </div>
                                </template>
                            </div>
                            <template x-if="!replyMessage.deleted_at">
                                <p class="text-sm font-normal pt-2.5 text-gray-900" x-text="replyMessage.message"></p>
                            </template>
                            <template x-if="replyMessage.deleted_at">
                                <span class="text-sm font-normal pt-2.5 text-gray-500 italic">The message has been deleted</span>
                            </template>

                            <template x-if="replyMessage.is_edited && !replyMessage.deleted_at">
                                <p class="text-gray-500 text-xs pt-3">(Edited on <span x-text="replyMessage.updated_at"></span>)</p>
                            </template>
                        </div>
                    </div>
                </template>
                <form x-on:submit.prevent="sendMessage('{{ $selected_application['application'] }}','{{ $selected_application['sender_id'] }}','{{ $selected_application['receiver_id'] }}')" class="flex items-center mx-auto w-full mt-auto">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 " viewBox="-2 -2 24 24"><path fill="currentColor" d="m5.72 14.456l1.761-.508l10.603-10.73a.456.456 0 0 0-.003-.64l-.635-.642a.443.443 0 0 0-.632-.003L6.239 12.635zM18.703.664l.635.643c.876.887.884 2.318.016 3.196L8.428 15.561l-3.764 1.084a.9.9 0 0 1-1.11-.623a.9.9 0 0 1-.002-.506l1.095-3.84L15.544.647a2.215 2.215 0 0 1 3.159.016zM7.184 1.817c.496 0 .898.407.898.909a.903.903 0 0 1-.898.909H3.592c-.992 0-1.796.814-1.796 1.817v10.906c0 1.004.804 1.818 1.796 1.818h10.776c.992 0 1.797-.814 1.797-1.818v-3.635c0-.502.402-.909.898-.909s.898.407.898.91v3.634c0 2.008-1.609 3.636-3.593 3.636H3.592C1.608 19.994 0 18.366 0 16.358V5.452c0-2.007 1.608-3.635 3.592-3.635z"/></svg>
                        </div>
                        <input type="text" x-model="messageValue" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Send Message for recruiter"  />
                        <button type="button" class="absolute inset-y-0 end-0 flex items-center pe-3">
                            <svg class="w-4 h-4 text-gray-500  hover:text-gray-900 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7v3a5.006 5.006 0 0 1-5 5H6a5.006 5.006 0 0 1-5-5V7m7 9v3m-3 0h6M7 1h2a3 3 0 0 1 3 3v5a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V4a3 3 0 0 1 3-3Z"/>
                            </svg>
                        </button>
                    </div>
                    <template x-if="sending" x-cloak>
                        <div class="inline-flex items-center py-2 px-7 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><circle cx="18" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="6" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>
                        </div>
                    </template>
                    <template x-if="!sending" x-cloak>
                        <button class="inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="16" height="16" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14L21 3m0 0l-6.5 18a.55.55 0 0 1-1 0L10 14l-7-3.5a.55.55 0 0 1 0-1z"/></svg>Send
                        </button>
                    </template>
                </form>
            </div>
        </template>
    </div>
@else
    <div class="text-center">
        <img class="w-64 h-64 mx-auto" src="/illustration/no-selected.svg" alt="">
        <p class="text-gray-500 text-lg">Please select job application to see the details</p>
    </div>
@endif
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chattingFunction', () => ({
            
            messageValue: "",
            openChatMenu: "",
            initialLoadErrorValue: "",
            messages: [],

            replyMessage: {},

            sending: false,
            initialLoadLoading: false,

            showPopupEdit: false,
            closedChat: "{{ ($selected_application != null && $selected_application['application']->status == 'rejected') ? true : false }}",
            selectedForEdit: [],

            initialize(){
                let jobId = "{{ ($selected_application != null && $selected_application['application'] != null) ? $selected_application['application']->job->id : '' }}"
                
                if(jobId) {
                    // get reactive from broadcast sent, edited, and deleted
                    Echo.private("private-chat.{{ $selected_application['application']->id ?? '' }}")
                    .listen('ChatEvent', (data) => {
                        if(data.message.event_type == "sending"){ 
                           this.messages.push(data.message)
                        } else{
                            let messageId = this.messages.findIndex(message => message.id == data.message.id)
                            this.messages[messageId] = data.message
                        }
                    });

                    this.initialLoadLoading = true

                    // initial load the related chat
                    axios.get(`/job/message/${jobId}`).then((res) => {
                        this.messages = res.data
                    }).catch((err) => {
                        if(err.response){
                            this.initialLoadErrorValue = err.response.data.message;
                        }
                        console.log(err.response)
                    }).finally(() => {
                        this.initialLoadLoading = false
                    })

                }
            },

            sendMessage(application, senderId, receiverId) {
                
                if (this.messageValue.trim() == "" || this.sending) return
                
                this.sending = true;
                let applicationParsed = JSON.parse(application);

                axios.post("/send-message", {
                    message: this.messageValue,
                    messageId: this.replyMessage.id,
                    appId: applicationParsed.id,
                    jobId: applicationParsed.job.id,
                    senderId: senderId,
                    receiverId: receiverId
                }).catch((err) => {
                    console.log(err,err.response)
                }).finally(() => {
                    this.replyMessage = {}
                    this.sending = false
                    this.messageValue = ""
                    this.initialLoadErrorValue = ""
                })
            },

            doReplyMessage(messageId){
                let id = this.messages.findIndex(message => message.id == messageId)
                this.replyMessage = this.messages[id]
            },

            loadReplyMessage(messageId){
                return this.messages[this.messages.findIndex(message => message.id == messageId)]
            },

            sendEditedMessage(messageId) {
                if(this.sending) return
                this.sending = true

                axios.post("/send-edited-message", {
                    messageId: messageId,
                    message: this.selectedForEdit.message
                }).catch((err) => {
                    console.log(err,err.response)
                }).finally(() => {
                    this.sending = false
                    this.showPopupEdit = false
                })
            },

            removeReplyMessage() {
                if(!this.sending) this.replyMessage = {};
            },

            deletedMessage(messageId){
                if(this.sending) return
                this.sending = true

                axios.post("/delete-message", {
                    messageId: messageId,
                }).catch((err) => {
                    console.log(err,err.response)
                }).finally(() => {
                    this.sending = false
                })   
            },

            minimizeContent(messages, idx){
                if(idx >= 1 && messages[idx-1].sender_id == messages[idx].sender_id || 
                    idx >= 1 && messages[idx-1].receiver_id == messages[idx].receiver_id){
                    return false
                } else{
                    return true;
                }
            },

            editMessage(messageId) {
                let message = this.messages.find(message => message.id == messageId);
                this.selectedForEdit = JSON.parse(JSON.stringify(message))
                this.showPopupEdit = !this.showPopupEdit
            }
        }))
    })
</script>