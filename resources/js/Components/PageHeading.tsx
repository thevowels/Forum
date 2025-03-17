import React from "react";


export default function PageHeading({ children }: { children?: React.ReactNode }) {
    return (
      <div className="font-semibold text-xl text-gray-800 leading-tight">
        {children}
      </div>
    );
}
