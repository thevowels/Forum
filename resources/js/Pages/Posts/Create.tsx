import React from "react";
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import AppLayout from '@/Layouts/AppLayout';
import InputLabel from '@/Components/InputLabel';
import { Input, Textarea } from '@headlessui/react';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import MarkdownEditor from '@/Components/MarkdownEditor';
import PageHeading from '@/Components/PageHeading';
export default function Create(){

    const {data, setData, post, put,  errors, processing, reset, recentlySuccessful } =
        useForm({
            body: '',
            title: ''
        });

    const submitPost = (e:any) => {
        e.preventDefault();
        post(route('posts.store'),{
            preserveScroll: true,
        })
    }
    return(
        <AppLayout title={"Create a Post"}
                   renderHeader={() => (
                       <PageHeading>
                           Create Post
                       </PageHeading>
                   )}
        >
            <div className="max-w-2xl mx-auto  my-4 p-8 text-sm bg-white rounded-xl">

                <form className={"max-w-2xl"} onSubmit={submitPost}>
                    <div className={""}>
                        {/*TODO: Title*/}
                        <InputLabel htmlFor="title"><span className={"text-lg"}>Title</span></InputLabel>
                        <Input
                            className={"mt-1 block w-full rounded-lg border-gray-300"}
                            value={data.title}
                            onChange={(e:any) => setData('title', e.target.value)}
                            placeholder="Post Title"
                        />
                        <InputError message={errors.title} />

                    </div>

                    <div className={"mt-4"}>
                        {/*    TODO: Body*/}
                        <InputLabel htmlFor="body"><span className={"text-lg"}>Body</span></InputLabel>
                        <Textarea
                            className="w-full p-2 border-gray-300 rounded-md resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows={15}
                            value={data.body}
                            onChange={(e:any) => setData('body', e.target.value)}
                            placeholder="Post Body"
                            />
                        <InputError message={errors.body} />


                    </div>

                    <div>
                        {/*    TODO: Action*/}
                        <PrimaryButton>Create Post</PrimaryButton>
                    </div>
                </form>

            </div>

        </AppLayout>
    )
}
