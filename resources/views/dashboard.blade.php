<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center" style="justify-content:space-between;">
            <h3 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('InstaApp') }}
            </h3>
            <a href="{{ route('post.create') }}">
                <div class="py-2 px-4 flex w-3/2 bg-yellow-400 hover:bg-yellow-200 text-slate-900 rounded-md shadow-md">
                    <h2 class="text-xl font-medium">Posting</h2>
                    <img class="w-[30px]" src="/plus.svg">
                </div>
            </a>
        </div>
    </x-slot>


    @if(!$posts)
    <div class="w-2/3 mx-auto my-6 bg-slate-900 border-2 rounded-md">
        <p class="text-2xl font-medium text-slate-100">Postingan Belum Tersedia</p>
    </div>
    @else
    @foreach($posts as $post)
    <div class="flex justify-center items-center w-1/3 mx-auto my-6">
        <div class="bg-gray-700 rounded-lg w-full border border-gray-600 shadow-lg">
            <div class="flex mx-6 mt-4 text-2xl font-semibold text-slate-100" style="justify-content: space-between;">
                <h2 class="text-2xl">{{ $post->User->name }}</h2>
                <div class="flex justify-start gap-x-4 text-xl font-thin">
                    @if(auth()->user() && auth()->user()->id === $post->user_id)
                    <form action="{{ route('post.destroy', ['post' => $post->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="border-0 underline underline-offset-4 text-red-600">Delete</button>
                    </form>
                    <a href="{{ route('post.edit', ['post' => $post->id]) }}" class="underline underline-offset-4 text-blue-600">Edit</a>
                    @endif
                </div>
            </div>
            <div class="my-4 rounded-md mx-auto w-full"><img src="{{ asset('storage/' . $post->image) }}" /></div>
            <div class="py-2 px-6 text-slate-100">
                <p class="text-xl">{{ $post->text }}</p>
                <div class="card-actions mt-4 mb-2 mr-2 justify-end">
                    <div class="w-1/2 flex gap-2 justify-end">
                        <div class="mt-[5px]">
                            <p>{{ $post->like_count }}</p>
                        </div>
                        <div class="flex flex-row gap-x-4">
                            <form action="{{ route('like.post', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <button type="submit">
                                    <img class="w-[30px] focus:fill-red-600" src="/love2.svg">
                                </button>
                            </form>
                            {{-- <form action=""> --}}
                                <button class="commentBtn">
                                    <img class="mt-[4px] w-[30px]" src="/comment.svg">
                                </button>
                            {{-- </form> --}}

                            <div class="commentDisplay hidden fixed inset-x-0 inset-y-0 m-auto">
                                <div class="comment relative mx-auto my-[3%] h-4/5 w-2/5 shadow-lg rounded-lg bg-gray-800 border-t  overflow-y-scroll">
                                    <div class="flex justify-center items-center bg-gray-900 w-full py-4 rounded-t-lg">
                                        <h3 class="text-2xl">Comment</h3>
                                        <button class="toggleBack absolute right-4">
                                            <a href="">kembali</a>
                                        </button>
                                    </div>
                                    @foreach ($post->comments as $comment)
                                        <div class="w-full p-6 whitespace-normal">
                                            <div class="flex" style="justify-content: space-between;">
                                                <h3 class="pb-2 text-xl font-medium">{{ $comment->User->name }}</h3>
                                                @if(auth()->user() && auth()->user()->id === $comment->user_id)
                                                    <div class="flex items-center mb-2 gap-2">
                                                        <form action="{{ route("comment.destroy", $comment->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="font-medium border-0 text-rose-600">Delete</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                            <p class="font-thin">{{ $comment->text }}</p>
                                        </div>
                                    @endforeach
                                    <div class="fixed inset-x-0 bottom-[60px] w-2/5 mx-auto bg-gray-800 rounded-t-md shadow-xl">
                                        <form action="{{ route('comment.store') }}" method="POST" class="flex">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                                            <input class="w-5/6 text-slate-950 rounded-l-md" type="text" name="text">
                                            <button type=submit class="px-6 bg-purple-700 rounded-r-md">send</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let commentBtns = document.querySelectorAll(".commentBtn");
            let toggleBacks = document.querySelectorAll(".toggleBack");

            commentBtns.forEach(function(commentBtn) {
                commentBtn.addEventListener("click", function(event) {
                    event.stopPropagation();

                    let commentDisplay = this.parentNode.querySelector(".commentDisplay");
                    if (commentDisplay.style.display === "none" || commentDisplay.style.display === "") {
                        commentDisplay.style.display = "block";
                    } else {
                        commentDisplay.style.display = "none";
                    }
                });
            });

            toggleBacks.forEach(function(toggleBack) {
                toggleBack.addEventListener("click", function(event) {
                    let commentDisplay = this.parentNode.parentNode;
                    commentDisplay.style.display = "none";
                });
            });
        });

    </script>
</x-app-layout>
