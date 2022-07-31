<section class="depth-1">
  <h1 class ="text-lg font-bold" >Funciones</h1>
</section>
<section class="WWListFeatures">
  <table class="min-w-full">
    <thead>
      <tr>
      <th>Código</th>
      <th>Descripcion</th>
      <th>Estado</th>
      <th>Tipo</th>
      <th>
        {{if CanInsert}}
        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded " href="index.php?page=admin_funcion&mode=INS&fncod=AUTOMATIC">Nuevo</a>
        {{endif CanInsert}}
        
      </th>
      </tr>
    </thead>
    <tbody class="bg-white">
      {{foreach Funciones}}
      <tr>
        <td>{{fncod}}</td>
        
        <td><a href="index.php?page=admin_funcion&mode=DSP&fncod={{fncod}}">{{fndsc}}</a></td>
        <td><span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">{{fnest}}</span></td>
        <td><span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">{{fntyp}}</span></td>
        <td class="flex justify-items-center place-content-center">
          {{if ~CanUpdate}}
          <a href="index.php?page=admin_funcion&mode=UPD&fncod={{fncod}}" title="Editar">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
          </a>
          {{endif ~CanUpdate}}
          &nbsp;
          {{if ~CanDelete}}
          <a href="index.php?page=admin_funcion&mode=DEL&fncod={{fncod}}" title="Eliminar">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
          </a>
          
          {{endif ~CanDelete}}
        </td>
      </tr>
      {{endfor Funciones}}
    </tbody>
  </table>
</section>