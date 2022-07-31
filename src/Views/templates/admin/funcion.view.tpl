<h1 class ="text-lg font-bold" >{{mode_dsc}}</h1>
<section>
{{if isDEL}}
  <div class="flex items-center " role="alert">
    <div class ="flex items-center p-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
      <svg class="m-1 w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
      <strong class="font-bold">Advertencia!</strong>
      <span class="block sm:inline">Está a punto de eliminar una función de que podría estar ligado un rol que a su vez a un usuario</span>
    </div>
  </div>
  {{endif isDEL}}
  <form class="w-full max-w-sm" action="index.php?page=mnt_feature&mode={{mode}}&fncod={{fncod}}"
    method="POST" >
    <section class="md:flex md:items-center mb-6">
    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="fncod">Código de Funcion</label>
    <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-gray-300 focus:border-purple-500" type="text" {{readonly}} {{ifnot isINS}}readonly{{endifnot isINS}} id="fncod" name="fncod" value="{{fncod}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
    </section>
    <section class="md:flex md:items-center mb-6">
      <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="fndsc">Descripción de la Funcion</label>
      <input class="bg-white appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" {{readonly}} name="fndsc" value="{{fndsc}}" maxlength="45" placeholder="Descripcion de la Funcion"/>
    </section>
    <section class="md:flex md:items-center mb-6">
      <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="fnest">Estado de la Funcion </label>
      {{if readonly}}
      <input type="hidden" id="funestdummy" name="fnest" value=""/>
      {{endif readonly}}
      <select class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" id="fnest" name="fnest" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{fnest_ACT}}>Activo</option>
        <option value="INA" {{fnest_INA}}>Inactivo</option>
      </select>
    </section>

    <section class="md:flex md:items-center mb-6">
        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for ="fntyp"> Tipo</label>
        {{if readonly}}
      <input type="hidden" id="funtypdummy" name="fntyp" value=""/>
      {{endif readonly}}
      <select class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" id="fntyp" name="fntyp" {{if readonly}}disabled{{endif readonly}}>
        <option value="CRT" {{fntyp_CRT}}>CRT</option>
        <option value="PCR" {{fntyp_PCR}}>PCR</option>
      </select>

    </section>

      {{if hasErrors}}
        <section>
          <ul>
            {{foreach Errors}}
                <li>{{this}}</li>
            {{endfor Errors}}
          </ul>
        </section>
    {{endif hasErrors}}
    <section>
      {{if showaction}}
      <button class="h-10 px-5 m-2 text-blue-100 transition-colors duration-150 bg-blue-600 rounded-lg focus:shadow-outline hover:bg-blue-700" type="submit" name="btnGuardar" value="G">Guardar</button>
      {{endif showaction}}
      <button class="h-10 px-5 m-2 text-red-100 transition-colors duration-150 bg-red-700 rounded-lg focus:shadow-outline hover:bg-red-800" type="button" id="btnCancelar">Cancelar</button>
    </section>
  </form>
</section>


<script>
  document.addEventListener("DOMContentLoaded", function(){
      document.getElementById("btnCancelar").addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_features");
      });
  });
</script>