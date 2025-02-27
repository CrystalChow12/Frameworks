<div class="flex flex-col">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="border rounded-lg divide-y divide-gray-200">
        <div class="py-3 px-4">
          <div class="relative max-w-xs">
            <label for="hs-table-search" class="sr-only">Search</label>
            <input type="text" name="hs-table-search" id="hs-table-search" class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Search for items">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
              <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
              </svg>
            </div>
          </div>
        </div>
        <div class="overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="py-3 px-4 pe-0">
                  <div class="flex items-center h-5">
                    <input id="hs-table-search-checkbox-all" type="checkbox" class="border-gray-200 rounded text-blue-600 focus:ring-blue-500">
                    <label for="hs-table-search-checkbox-all" class="sr-only">Checkbox</label>
                  </div>
                </th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Username</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Age</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Address</th>
                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr>
                <td class="py-3 ps-4">
                  <div class="flex items-center h-5">
                    <input id="hs-table-search-checkbox-1" type="checkbox" class="border-gray-200 rounded text-blue-600 focus:ring-blue-500">
                    <label for="hs-table-search-checkbox-1" class="sr-only">Checkbox</label>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">John Brown</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">45</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">New York No. 1 Lake Park</td>
                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                  <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">Delete</button>
                </td>
              </tr>

              <tr>
                <td class="py-3 ps-4">
                  <div class="flex items-center h-5">
                    <input id="hs-table-search-checkbox-2" type="checkbox" class="border-gray-200 rounded text-blue-600 focus:ring-blue-500">
                    <label for="hs-table-search-checkbox-2" class="sr-only">Checkbox</label>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Jim Green</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">27</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">London No. 1 Lake Park</td>
                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                  <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">Delete</button>
                </td>
              </tr>

              <tr>
                <td class="py-3 ps-4">
                  <div class="flex items-center h-5">
                    <input id="hs-table-search-checkbox-3" type="checkbox" class="border-gray-200 rounded text-blue-600 focus:ring-blue-500">
                    <label for="hs-table-search-checkbox-3" class="sr-only">Checkbox</label>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Joe Black</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">31</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Sidney No. 1 Lake Park</td>
                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                  <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">Delete</button>
                </td>
              </tr>

              <tr>
                <td class="py-3 ps-4">
                  <div class="flex items-center h-5">
                    <input id="hs-table-search-checkbox-4" type="checkbox" class="border-gray-200 rounded text-blue-600 focus:ring-blue-500">
                    <label for="hs-table-search-checkbox-4" class="sr-only">Checkbox</label>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Edward King</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">16</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">LA No. 1 Lake Park</td>
                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                  <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">Delete</button>
                </td>
              </tr>

              <tr>
                <td class="py-3 ps-4">
                  <div class="flex items-center h-5">
                    <input id="hs-table-search-checkbox-5" type="checkbox" class="border-gray-200 rounded text-blue-600 focus:ring-blue-500">
                    <label for="hs-table-search-checkbox-5" class="sr-only">Checkbox</label>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Jim Red</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">45</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Melbourne No. 1 Lake Park</td>
                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                  <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>