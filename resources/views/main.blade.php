<!doctype html>
<html lang="es" class="h-100" data-bs-theme="auto">

<head>
    <!-- https://getbootstrap.com/docs/5.3/examples/sticky-footer/ -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <meta name="theme-color" content="#712cf9">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url-base" content="{{ url('') }}">

    <title>Fetch</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .container {
            width: auto;
            max-width: 680px;
            padding: 0 15px;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <!-- Modal -->
    @include('modal')
    <!-- Begin page content -->
    <main class="flex-shrink-0">
        <div class="container">
            <h1 class="mt-5">Product</h1>

            <p class="lead">
                Tercera versión de la misma aplicación de productos: fetch (ajax).
            </p>
            <div id="alertPlaceholder"></div>
            <div id="content"></div>
            <div id="pagination" class="mt-3"></div>



            <!--
                <div>
                    <button type="button" class="btn btn-primary" data-id="33" data-name="pepe" data-email="pepe@pepe.es" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Launch demo modal
                    </button>
                </div>
                -->

        </div>
    </main>

    <footer class="footer mt-auto py-3 bg-body-tertiary">
        <div class="container">
            <span class="text-body-secondary">Place sticky footer content here.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        const exampleModal = document.getElementById('exampleModal')
        if (exampleModal) {
            exampleModal.addEventListener('show.bs.modal', event => {
                console.log('example modal visualizado')
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-id')

                // Update the modal's content.
                const modalTitle = exampleModal.querySelector('.modal-title')
                //const modalBodyInput = exampleModal.querySelector('.modal-body input')

                modalTitle.textContent = `New message to ${id}`
                //modalBodyInput.value = recipient
            })
        }
    </script>

    <script>
        const content = document.getElementById('content')
        const pagination = document.getElementById('pagination')
        const csrf = document.querySelector('meta[name="csrf-token"]')['content']
        const mainUrl = document.querySelector('meta[name="url-base"]')['content']

        const renderPagination = (links) => {
            pagination.innerHTML = ''
            links.forEach(link => {
                if (link.url != null) {
                    const button = document.createElement('button')
                    button.innerHTML = link.label
                    button.classList.add('btn', 'btn-outline-primary', 'mx-1')
                    if (link.active) {
                        button.classList.add('active')
                    }
                    button.addEventListener('click', () => {
                        fetch(link.url)
                            .then(response => response.json())
                            .then(data => {
                                content.innerHTML = ''
                                renderFetchData(data)
                            })
                    })
                    pagination.appendChild(button)
                }
            })
        }
        const renderFetchData = (data) => {
            console.log(data)
            const buttonCreate = document.createElement('button')
            buttonCreate.textContent = 'create'
            buttonCreate.setAttribute('data-bs-toggle', 'modal');
            buttonCreate.setAttribute('data-bs-target', '#createModal');
            buttonCreate.classList.add('btn', 'btn-success');
            buttonCreate.dataset.url = "/product";
            buttonCreate.dataset.method = "post";
            content.appendChild(buttonCreate);

            data.products.data.forEach(element => {
                const div = document.createElement('div');
                /*for (const key in element) {
                    div.textContent = element[key];
                }*/
                const { id, name, price } = element //destructuring assignment
                div.textContent = id + ' ' + name + ' ' + price

                const buttonView = document.createElement('button')
                buttonView.textContent = 'view'
                //class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                buttonView.setAttribute('data-bs-toggle', 'modal');
                buttonView.setAttribute('data-bs-target', '#viewModal');
                buttonView.classList.add('btn', 'btn-primary');
                buttonView.dataset.id = id;
                buttonView.dataset.name = name;
                buttonView.dataset.value = price;
                buttonView.dataset.url = "/product/" + id;
                buttonView.dataset.method = "get";

                const buttonEdit = document.createElement('button')
                buttonEdit.textContent = 'edit'
                buttonEdit.setAttribute('data-bs-toggle', 'modal');
                buttonEdit.setAttribute('data-bs-target', '#editModal');
                buttonEdit.classList.add('btn', 'btn-warning');
                buttonEdit.dataset.id = id;
                buttonEdit.dataset.name = name;
                buttonEdit.dataset.value = price;
                buttonEdit.dataset.url = "/product/" + id;
                buttonEdit.dataset.method = "put";

                const buttonDelete = document.createElement('button')
                buttonDelete.textContent = 'delete'
                buttonDelete.setAttribute('data-bs-toggle', 'modal');
                buttonDelete.setAttribute('data-bs-target', '#deleteModal');
                buttonDelete.classList.add('btn', 'btn-danger');
                buttonDelete.dataset.id = id;
                buttonDelete.dataset.name = name;
                buttonDelete.dataset.value = price;
                buttonDelete.dataset.url = "/product/" + id;
                buttonDelete.dataset.method = "delete";

                div.appendChild(buttonView)
                div.appendChild(buttonEdit)
                div.appendChild(buttonDelete)

                content.appendChild(div);
            });
            renderPagination(data.products.links);
        }

        const modalEdit = document.getElementById('editModal')
        modalEdit.addEventListener('show.bs.modal', event => {
            console.log("Edit");
            console.log(event.relatedTarget.dataset.id);
        });
        const modalDeleteConfirm = document.getElementById('bt-confirm-delete');
        const modalDelete = document.getElementById('deleteModal');
        let deleteData;
        const modalIdDelete = document.getElementById('deleteModalName');
        modalDelete.addEventListener('show.bs.modal', event => {
            console.log("Delete");
            console.log(event.relatedTarget.dataset.id);
            modalIdDelete.textContent = event.relatedTarget.dataset.name;
            deleteData = {
                url: event.relatedTarget.dataset.url,
                method: event.relatedTarget.dataset.method
            }
        });

        modalDeleteConfirm.addEventListener('click', () => {
            genericFetch(deleteData.url, deleteData.method, (data) => {
                if (data.result) {
                    console.log("todo ha ido bien, cierra la ventana");
                    const modalInstance = bootstrap.Modal.getInstance(modalDelete);
                    modalInstance.hide();
                    showAlert("Eliminado correctamente", "success");
                    //recargar la lista de productos
                    content.innerHTML = '';
                    renderFetchData(data);

                } else {
                    console.log("algo ha fallado");
                    //añado dentro del modal un mensaje de error
                    const modalBody = modalDelete.querySelector('.modal-body');
                    modalBody.innerHTML = '<div class="alert alert-danger" role="alert">Error al eliminar</div>';
                }
            });
        });


        const modalView = document.getElementById('viewModal')
        modalView.addEventListener('show.bs.modal', event => {
            console.log("View");
            console.log(event.relatedTarget.dataset.id);
        });

        function genericFetch(url, method, callBack) {
            fetch(mainUrl + url, {
                method: method,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrf
                },
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    callBack(data)
                });
        }

        function showAlert(message, type) {
            const alertPlaceholder = document.getElementById('alertPlaceholder');
            const wrapper = document.createElement('div');
            wrapper.innerHTML = `<div class="alert alert-${type} alert-dismissible" role="alert">
                                ${message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                             </div>`;
            alertPlaceholder.append(wrapper);
        }
        //https://izvserver.hopto.org/laraveles/bootstrapApp/public/product
        //ejecucion diferida a lo largo del tiempo
        //1º fetch -> request/peticion a un ordenador -> tarda un tiempo
        //2º then  -> espera diferida de la llegada completa de la respuesta
        //3º then -> engtrega de respuesta transformada a json
        fetch(mainUrl + '/product')
            .then(response => response.json())
            .then(data => renderFetchData(data))
    </script>
</body>

</html>