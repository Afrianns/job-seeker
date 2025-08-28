@if ($selected_application)
    <div class="py-3 px-5 space-y-5 border border-gray-300 rounded-md h-full bg-gray-100 flex flex-col" x-data="chattingFunction" x-init="initialize">
        <div>
            <div class="border border-gray-200 px-3 py-2 flex items-center justify-between bg-white">
                <div>
                    <h4 class="font-medium">Your CV Document</h4>
                    <a target="_blank" href="{{ route('user-cv-file') }}" class="text-blue-500 hover:underline hover:text-blue-800">{{ $selected_application->name }}</a>
                </div>
                <div>
                    <p class="border border-gray-200 py-1 px-2">
                        Size: <strong>{{ $selected_application->size }}</strong>
                    </p>
                    <p class="border border-gray-200 py-1 px-2">
                        Type: <strong>{{ $selected_application->type }}</strong>
                    </p>
                </div>
            </div>
            <hr class="border-t border-gray-300 my-5 w-full">
        </div>

        <div class="h-full overflow-y-auto space-y-3 mt-auto">
            <template x-for="message in messages" :key="message.id">
                <div>
                    <template x-if="message.is_user_recruiter">
                        <div class="flex items-start gap-2.5">
                            <img class="w-8 h-8 rounded-full" :src="message.user_avatar" alt="Jese image">
                            <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-white rounded-e-xl rounded-es-xl">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="text-sm font-semibold text-gray-900" x-text="message.user_name"></span>
                                    <span class="text-sm font-normal text-gray-500" x-text="message.created_at">11:46</span>
                                </div>
                                <p class="text-sm font-normal pt-2.5 text-gray-900" x-text="message.message"></p>
                            </div>
                            <button id="left-bubble" data-dropdown-toggle="dropdownDots-left" data-dropdown-placement="bottom-start" class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50" type="button">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                    <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                </svg>
                            </button>
                            <div id="dropdownDots-left" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-40  ">
                                <ul class="py-2 text-sm text-gray-700 " aria-labelledby="left-bubble">
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Reply</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </template>
                    <template x-if="!message.is_user_recruiter">
                        <div class="flex items-start gap-2.5 flex-row-reverse">
                            <img class="w-8 h-8 rounded-full" :src="message.user_avatar" alt="Jese image">
                            <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-purple-200 rounded-s-xl rounded-ee-xl">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="text-sm font-semibold text-gray-900" x-text="message.user_name"></span>
                                    <span class="text-sm font-normal text-gray-500" x-text="message.created_at"></span>
                                </div>
                                <p class="text-sm font-normal pt-2.5 text-gray-900" x-text="message.message"></p>
                            </div>
                            <button id="right-bubble" data-dropdown-toggle="dropdownDots-right" data-dropdown-placement="bottom-end" class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50" type="button">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                    <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                </svg>
                            </button>
                            <div id="dropdownDots-right" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-40  ">
                                <ul class="py-2 text-sm text-gray-700 " aria-labelledby="right-bubble">
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Reply</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
            <div class="inline-flex items-center justify-center w-full relative" x-show="initialLoadErrorValue">
                <hr class="border-t border-gray-300 m-5 w-full">
                <p class="absolute bg-gray-100 px-3 text-center text-gray-600 text-md" x-text="initialLoadErrorValue"></p>
            </div>
        </div>

        <form x-on:submit.prevent="sendMessage('{{ $selected_application->job->id }}')" class="flex items-center mx-auto w-full mt-auto">
            <label for="voice-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 " viewBox="-2 -2 24 24"><path fill="currentColor" d="m5.72 14.456l1.761-.508l10.603-10.73a.456.456 0 0 0-.003-.64l-.635-.642a.443.443 0 0 0-.632-.003L6.239 12.635zM18.703.664l.635.643c.876.887.884 2.318.016 3.196L8.428 15.561l-3.764 1.084a.9.9 0 0 1-1.11-.623a.9.9 0 0 1-.002-.506l1.095-3.84L15.544.647a2.215 2.215 0 0 1 3.159.016zM7.184 1.817c.496 0 .898.407.898.909a.903.903 0 0 1-.898.909H3.592c-.992 0-1.796.814-1.796 1.817v10.906c0 1.004.804 1.818 1.796 1.818h10.776c.992 0 1.797-.814 1.797-1.818v-3.635c0-.502.402-.909.898-.909s.898.407.898.91v3.634c0 2.008-1.609 3.636-3.593 3.636H3.592C1.608 19.994 0 18.366 0 16.358V5.452c0-2.007 1.608-3.635 3.592-3.635z"/></svg>
                </div>
                <input type="text" id="voice-search" x-model="messageValue" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Send Message for recruiter"  />
                <button type="button" class="absolute inset-y-0 end-0 flex items-center pe-3">
                    <svg class="w-4 h-4 text-gray-500  hover:text-gray-900 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7v3a5.006 5.006 0 0 1-5 5H6a5.006 5.006 0 0 1-5-5V7m7 9v3m-3 0h6M7 1h2a3 3 0 0 1 3 3v5a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V4a3 3 0 0 1 3-3Z"/>
                    </svg>
                </button>
            </div>
            <button class="inline-flex items-center py-2.5 px-3 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="16" height="16" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14L21 3m0 0l-6.5 18a.55.55 0 0 1-1 0L10 14l-7-3.5a.55.55 0 0 1 0-1z"/></svg>Send
            </button>
        </form>
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
            initialLoadErrorValue: "",
            messages: [],

            initialize(){
                let jobId = "{{ ($selected_application != null) ? $selected_application->job->id : '' }}"
                if(jobId) {
                    axios.get(`/job/message/${jobId}`).then((res) => {
                        console.log(res)
                        this.messages = res.data
                    }).catch((err) => {
                        if(err.response){
                            this.initialLoadErrorValue = err.response.data.message;
                        }
                        console.log(err.response)
                    })

                }
            },

            sendMessage(jobId) {

                if (this.messageValue.trim() == "") return

                axios.post("/send-message", {
                    message: this.messageValue,
                    jobId: jobId
                }).then((res) => {
                    console.log(res.data)
                    this.messages.push(res.data)
                }).catch((err) => {
                    console.log(err,err.response)
                })

                this.messageValue = ""
                this.initialLoadErrorValue = ""
            }
        }))
    })
</script>