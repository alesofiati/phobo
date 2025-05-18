import React from 'react'
import { ErrorBag } from "../libs/api-client";

interface Props {
  errorBag: ErrorBag;
}

export default function ErrorMessage({ errorBag }: Props) {
  const firstErrorEntry = Object.entries(errorBag.errors)[0];

  if (!firstErrorEntry) return null;

  return (
    <span className="text-center text-red-300 text-sm">
      {firstErrorEntry[1][0]}
    </span>
  );
}
