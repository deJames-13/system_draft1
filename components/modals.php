<?php

function createModal($title = null, $message = null, $visible = false, $btnFunc = '', $btnFunc2 = null, $btnClose = null, $btnConfirm = null)
{
    $title = $title ?? "No title";
    $message = $message ?? "No message";
    $btnClose = $btnClose ?? "Close";
    $btnFunc2 = $btnFunc2 ?? "showModal(this)";
    $hidden = $visible ? '' : 'hidden';

    if ($btnConfirm == null) {
        $btnConfirm = "";
    } else {
        $btnConfirm = <<<HTML
        <button onclick="$btnFunc" class="px-4 py-2 bg-primary50 border border-accent text-accent rounded hover:bg-blue-400">$btnConfirm</button>
        HTML;
    }

    $modal = <<<HTML
<div class="${$hidden} fixed z-10 top-0 w-full left-0  overflow-y-auto" id="alert_modal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-900 opacity-20" />
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">
            &#8203;
        </span>

        <div class="h-full inline-block align-center overflow-y-auto py-8 transform transition-all align-middle w-full max-w-xl p-2" >

            <div id="modal-content" class="animate-fall container flex flex-col justify-between rounded-lg overflow-y-auto shadow-xl p-4 max-h-1/2 border border-accent30 bg-white text-left">
                <div class="pb-2 border-b-2 border-accent">
                    <h1 class="text-xl font-bold">
                        $title
                    </h1>
                </div>
                <div class="pt-2">
                    <p class="text-base">
                        $message
                    </p>
                </div>

                <!-- option buttons -->
                <div class="flex justify-end pt-2 space-x-4">
                    <button name="closeModal" class="px-4 py-2 bg-secondary30 text-accent border border-accent rounded hover:bg-red-400" onclick="$btnFunc2">$btnClose</button>

                    $btnConfirm
                </div>

            </div>
        </div>
    </div>
</div>
HTML;

    return $modal;
}
