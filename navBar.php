<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Navegação">
     <div class="container-fluid">
         <a class="navbar-brand" href="#">
             <img src="/img/logo.png" width="100" height="50">
             Quadro de Avisos</a>
         <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nav01" aria-controls="nav01" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>

         <div class="navbar-collapse collapse" id="nav01">
             <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                 <li class="nav-item">
                     <a class="nav-link" href="/">Avisos</a>
                 </li>
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="dropdownFuncoes" data-bs-toggle="dropdown" aria-expanded="false">Funções</a>
                     <ul class="dropdown-menu" aria-labelledby="dropdownFuncoes">
                         <li><a class="dropdown-item <?= $privlegio ?>" href="/?m=1" >Novo Aviso</a></li>
                         <li><a class="dropdown-item" href="/?ref=">Listar Todos os Avisos</a></li> 
                         <li><a class="dropdown-item" href="/">Listar Avisos não lidos ou fixados</a></li>
                         <li><a class="dropdown-item" href="sair.php">Sair</a></li>
                     </ul>
                 </li>
             </ul>
             <form>
                 <input class="form-control" type="text" placeholder="Pesquisar" aria-label="Search" name="ref">
             </form>
         </div>
     </div>
 </nav>