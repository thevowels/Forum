import React, { useRef } from 'react';
import AppLayout from '@/Layouts/AppLayout';
import { formatDistance } from "date-fns";
import { Link, usePage , Head} from '@inertiajs/react';
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
import PageHeading from '@/Components/PageHeading';
import {HandThumbUpIcon, HandThumbDownIcon} from '@heroicons/react/24/solid';

export default function Show({post, comments}:{post:any, comments:any}     ) {

    console.log(post);
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
            realPost(route('posts.comments.store', post),{
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
        let commentBeingEdit = comments.data.find((comment : any)  => comment.id === id);
        setData('body', commentBeingEdit.body);
    }

    // @ts-ignore
    return(
        <AppLayout
            title={post.title}
            renderHeader={() => (
                <PageHeading>
                    <div className="text-2xl font-semibold text-gray-700 leading-tight my-3">
                        <div>
                            <Link href={route('posts.index', {topic: post.topic?.slug})} className={"rounded-full py-0.5 px-2 border border-blue-300 text-blue-300 hover:bg-indigo-500 hover:text-white"}>
                                {post.topic.name}
                            </Link>

                        </div>
                        <div className={"mt-2"}>
                            {post?.title}

                        </div>
                        <div className="text-gray-600 mb-2 text-sm text-gray-500 font-light">
                            {formattedDate} Ago by
                            <Link href={`/posts/${post?.user?.id}`} className={"ml-2"}>
                                {post?.user.name}
                            </Link>

                        </div>

                    </div>
                </PageHeading>

            )}
        >

            <Head>
                <link rel={"canonical"} href={post.routes.show}/>
            </Head>
            <div>
                <div className="max-w-2xl lg:max-w-7xl mx-auto">
                    <div className="max-w-lg mx-auto bg-white my-4 p-8">
                        <div className="text-gray-800 text-base whitespace-pre-wrap font-sans indent-8 text-wrap break-words">
                            {post?.body}
                        </div>
                        <div className="mt-4 flex justify-between">
                            <span className={"text-pink-500 font-bold"}>
                                {post?.likes_count} Likes
                            </span>
                            {
                                page.props.auth?.user &&
                                (post.can?.like ?
                                <Link preserveScroll href={route('likes.store', ['post', post.id])} method={"post"} as={"button"}>
                                    <HandThumbUpIcon height={24} color={"green"}/>
                                </Link>
                                :
                                <Link preserveScroll href={route('likes.destroy', ['post', post.id])} method={"delete"} as={"button"}>
                                    <HandThumbDownIcon height={24} color={"red"}/>
                                </Link>
                                )

                            }


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
                                        <span className={"font-semiboldtext-gray-800"}>By</span> <span className={"font-bold text-blue-950"}>{comment.user?.name}</span> | <span className={"text-pink-500 "}>{comment.likes_count} Likes</span>
                                        <span className="ml-2">{formatDistance(comment?.created_at || new Date(), new Date())}</span> ago
                                    </div>
                                    { page.props.auth?.user && (
                                        comment.can?.like ?
                                            <Link preserveScroll href={route('likes.store', ['comment', comment.id])} method={"post"} as={"button"}  >
                                                <HandThumbUpIcon height={24} color={"green"} as={"button"} className={"inline"}/> Like Comment
                                            </Link>
                                            :
                                            <Link preserveScroll href={route('likes.destroy', ['comment', comment.id])} method={"delete"} as={"button"}>
                                                <HandThumbDownIcon height={24} color={"red"} as={"button"} className={"inline"}/> Unlike Comment
                                            </Link>
                                    )

                                    }

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
