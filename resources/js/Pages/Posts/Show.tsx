import React from "react";
import AppLayout from '@/Layouts/AppLayout';
import { formatDistance } from "date-fns";
import { Link } from '@inertiajs/react';
export default function Show({post}:{post:any}     ){
    console.log('called show', post);
    const formattedDate = formatDistance(post?.created_at || new Date(), new Date());
    console.log(formattedDate);
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
                        <div className="text-gray-800 text-base whitespace-pre-wrap font-sans">
                            {post?.body}

                        </div>
                        <div className="text-right">

                        </div>

                    </div>
                </div>
            </div>
        </AppLayout>
    )
}
