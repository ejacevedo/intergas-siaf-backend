
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="search" wire:model="search">
                </div>
        </div>
    </div>
</div>


<div class="page-body">
        
          
    <div class="card">
        <div class="mt-3 card-block table-border-style">
            <!-- <div wire:loading class="content-loader">
            </div> -->
            <div class="table-responsive">
                
                <table class="table">
                    <thead>
                        <tr>
                            
                            <th>id</th>
                            <th>name</th>
                            <th>Nivel</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                               
                               
                            </tr>

                        @endforeach

                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>