import React, { useRef } from 'react';
import AppLayout from '@/Layouts/AppLayout';
import { formatDistance } from "date-fns";
import { Link, usePage } from '@inertiajs/react';
import {relativeDate} from '@/Utilities/date';
import Pagination from '@/Components/Pagination';
import InputLabel from '@/Components/InputLabel';
import { Input } from '@headlessui/react';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import { useForm } from "@inertiajs/react";
import InputError from '@/Components/InputError';
import { route } from 'ziggy-js';
import { router } from '@inertiajs/core';
import { useComputed } from '@headlessui/react/dist/hooks/use-computed';

export default function Show({post, comments}:{post:any, comments:any}     ) {
    const page = usePage();
    const formattedDate = formatDistance(post?.created_at || new Date(), new Date());
    const {data, setData, post: realPost, put,  errors, processing, reset, recentlySuccessful } =
        useForm({
            body: '',
        });
    const submit = (e:any) => {
        e.preventDefault();
        if(commentIdBeingEdited.current)
        {
            put(route('comments.update', {comment: commentIdBeingEdited.current, page:comments?.meta?.current_page}),{
                preserveScroll:true,
                onSuccess: (response:any) => {
                    commentIdBeingEdited.current=null;
                }
            })
        }else{
            realPost(route('posts.comments.store', post.id),{
                preserveScroll: true,
            });

        }
        reset();

    }


    const deleteComment = (id: string) => {
        router.delete(route('comments.destroy', { comment:id, page:comments?.meta?.current_page }), {
          preserveScroll: true,
        });
    }

    const commentIdBeingEdited: any = useRef(null);
    const editComment = (id: string) => {
        commentIdBeingEdited.current=id;
        let commentBeingEdit = comments.data.find(comment => comment.id === id);
        setData('body', commentBeingEdit.body);
    }

    // @ts-ignore
    return(
        <AppLayout
            title={post.title}
            renderHeader={() => (
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    {post?.title}
                </h2>
            )}
        >
            <div>
                <div className="max-w-2xl lg:max-w-7xl mx-auto">
                    <div className="max-w-lg mx-auto bg-white my-4 p-8">
                        <div className="text-2xl font-semibold text-gray-700 leading-tight my-3">
                            {post?.title}
                        </div>
                        <div className="text-gray-600 mb-2">
                            {formattedDate} Ago by
                            <Link href={`/posts/${post?.user?.id}`}>
                                {post?.user.name}
                            </Link>

                        </div>
                        <div className="text-gray-800 text-base whitespace-pre-wrap font-sans indent-8">
                            {post?.body}

                        </div>
                    </div>

                    <div className="max-w-2xl mx-auto  my-4 p-8 text-sm">
                        {page.props.auth?.user &&

                            <div>
                                <form className={"max-w-2xl"} onSubmit={submit}>
                                    <div className="py-2">
                                        <InputLabel htmlFor="comment">Add Comment</InputLabel>
                                        <Input
                                            className={"mt-1 block w-full rounded-lg border-gray-300 h-[6rem]"}
                                            value={data.body}
                                            onChange={(e:any) => {setData('body',e.target.value)}}
                                            placeholder={"What's on your mind?"}
                                        />
                                        <InputError message={errors.body} className={"mt-2"}/>
                                    </div>
                                    <div>
                                        <PrimaryButton>
                                            { commentIdBeingEdited.current == null ? 'Add Comment':'Update Comment' }
                                        </PrimaryButton>
                                        {commentIdBeingEdited.current &&
                                            <SecondaryButton onClick={(e)=> {
                                                e.preventDefault();
                                                commentIdBeingEdited.current=null;
                                                reset();
                                            }}>
                                                Cancel
                                            </SecondaryButton>

                                        }

                                    </div>

                                </form>
                            </div>

                        }
                        <div className={"font-bold text-lg"}>
                            Comments
                        </div>
                        {comments.data.map((comment:any) => (
                            <div key={comment.id} className="mt-4 bg-white flex flex-row">
                                <div >
                                        <img src={comment?.user?.profile_photo_url}  />
                                </div>
                                <div className="w-full m-1 ml-4">
                                    <div className={"font-sans break-all"}>
                                        {comment.body}
                                    </div>
                                    <div>
                                        <span className={"font-semiboldtext-gray-800"}>By</span> <span className={"font-bold text-blue-950"}>{comment.user?.name}</span>
                                        <span className="ml-2">{formatDistance(comment?.created_at || new Date(), new Date())}</span> ago
                                    </div>
                                    { comment.can?.delete &&
                                        <div className={"mt-1 text-right "}>
                                            <PrimaryButton onClick={()=> deleteComment(comment.id)}>
                                                Delete
                                            </PrimaryButton>
                                            <PrimaryButton className={"ml-4 mr-2"} onClick={()=> editComment(comment.id)}>
                                                Edit Comment
                                            </PrimaryButton>
                                        </div>

                                    }

                                </div>
                            </div>
                        ))}
                        <Pagination meta={comments.meta} links = {comments.links} only={['comments']}/>

                    </div>

                </div>
            </div>
        </AppLayout>
    )
}
