<!-- Make an Order -->
<!-- Order Modal -->
<div class="hidden fixed z-10 top-0 w-full left-0  overflow-y-auto" id="modal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-900 opacity-20" />
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">
            &#8203;
        </span>

        <div class="h-full inline-block align-center overflow-y-auto py-8 transform transition-all align-middle w-full max-w-xl" role="dialog" aria-modal="true" aria-labelledby="modal-headline">

            <div class="container flex flex-col justify-between rounded-lg overflow-y-auto shadow-xl h-full border border-accent30 bg-white pt-4">
                <h1 class="text-xl pb-4 font-bold text-accent border-b-2 md:text-3xl">
                    Order ID: 1
                </h1>

                <div class="h-full py-3 px-6 text-lef flex flex-col justify-between">
                    <!-- Order Details -->
                    <div>
                        <!-- Customer Info -->
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-light">
                                Purchase By: John Doe
                            </p>

                            <!-- Order Date -->
                            <p class="text-sm font-light">
                                Order Date: mm\dd\yyyy
                            </p>
                        </div>
                        <div class="flex flex-col items-start my-2">
                            <p class="text-sm font-light">
                                Shipping Address:
                                <br>
                            </p>
                            <textarea class="text-sm w-full items-start px-0 font-light resize-none" name="shipAddr" id="shipAddr">1234 Main St. City, State, Zip</textarea>
                        </div>

                        <!-- Item ID -->
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-light">
                                Item ID
                            </p>
                            <h1 class="text-md font-bold">
                                #1
                            </h1>
                        </div>

                        <!-- Item Name -->
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-light">
                                Name
                            </p>
                            <h1 class="text-lg">
                                Xiaomi Mi 11
                            </h1>
                        </div>

                        <!-- Price -->
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-light">
                                Price
                            </p>
                            <h1 class="text-md">
                                P14000
                            </h1>
                        </div>

                        <!-- Quantity -->
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-light">
                                Qty
                            </p>
                            <h1 class="text-md">
                                1
                            </h1>
                        </div>
                    </div>

                    <!-- Cost Summary -->
                    <div class="flex flex-col space-y-2">

                        <div class="h-[0.1rem] bg-accent"></div>
                        <!-- Sub Total -->
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-light">
                                Sub Total
                            </p>
                            <h1 class="text-md">
                                P14000
                            </h1>
                        </div>
                        <!-- Shipping Fee -->
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-light">
                                Shipping Fee
                            </p>
                            <h1 class="text-md">
                                150
                            </h1>
                        </div>
                        <!-- Total -->
                        <div class="flex justify-between items-center">
                            <p class="text-lg font-bold">
                                Total
                            </p>
                            <h1 class="text-lg font-bold">
                                P14150
                            </h1>
                        </div>
                    </div>

                </div>


                <div class="bg-gray-200 px-4 py-3 text-right ">

                    <button type="button" class="py-2 px-4 border border-red-600 rounded hover:bg-red-300 mr-2" onclick="toggleModal()"><i class="fas fa-times"></i> Cancel</button>

                    <button type="button" class="py-2 px-4 bg-primary rounded hover:bg-blue-400 hover:text-accent mr-2"><i class="fas fa-check"></i> Confirm</button>
                </div>
            </div>

        </div>
    </div>
</div>