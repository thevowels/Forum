import React from "react";
import {EditorContent, useEditor} from '@tiptap/react';
import Document from '@tiptap/extension-document';
import Paragraph from '@tiptap/extension-paragraph';
import Text from '@tiptap/extension-text';


export default function MarkdownEditor({setData, value}: {setData: any,value:any}) {

    const editor = useEditor({
        extensions: [
            Document,
            Paragraph,
            Text,
        ],
        content: `
      <p>
        This is a radically reduced version of Tiptap. It has support for a document, with paragraphs and text. That’s it. It’s probably too much for real minimalists though.
      </p>
      <p>
        The paragraph extension is not really required, but you need at least one node. Sure, that node can be something different.
      </p>
    `,
        onUpdate: (e:any) => {console.log(e)}
    })
    return(
        <div>
            <EditorContent editor={editor}/>

        </div>
    )
}
