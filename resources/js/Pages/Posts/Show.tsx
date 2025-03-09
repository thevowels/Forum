import React from "react";
import AppLayout from '@/Layouts/AppLayout';
import { formatDistance } from "date-fns";
import { Link } from '@inertiajs/react';
import {relativeDate} from '@/Utilities/date';
import Pagination from '@/Components/Pagination';

export default function Show({post, comments}:{post:any, comments:any}     ) {
    console.log('called show', post);
    const formattedDate = formatDistance(post?.created_at || new Date(), new Date());
    console.log(formattedDate);
    console.log('comments = > ', comments);
    return(
        <AppLayout
            title="Post Title"
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
                        <div className={"font-bold text-lg"}>
                            Comments
                        </div>
                        {comments.data.map((comment:any) => (
                            <div key={comment.id} className="mt-4  items-center justify-between bg-white flex">
                                <div>
                                        <img src={comment?.user?.profile_photo_url} width={140} />
                                </div>
                                <div className="ml-2">
                                    <div className={"whitespace-pre-wrap font-sans"}>
                                        {comment.body}
                                    </div>
                                    <div>
                                        <span className={"font-semibold text-gray-800"}>By</span> <span className={"font-bold text-blue-950"}>{comment.user?.name}</span>
                                        <span className="ml-2">{formatDistance(comment?.created_at || new Date(), new Date())}</span> ago
                                    </div>

                                </div>
                            </div>
                        ))}
                        <Pagination meta={comments.meta} links = {comments.links}/>

                    </div>

                </div>
            </div>
        </AppLayout>
    )
}
