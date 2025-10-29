import {createApp, h, nextTick, ref} from "vue";
import {Modal} from "flowbite";

class ModalService {
    open = (options = {}) => {
        const container = document.createElement('div');
        document.body.appendChild(container);

        const instanceRef = ref();

        options.props = options.props ? options.props : {};

        options.props.instance = instanceRef;

        const modalPromise = new Promise((resolve) => {
            nextTick(() => {
                const modalElement = container.querySelector('#modalEl');
                if (modalElement) {
                    const modal = new Modal(modalElement);

                    modal.show();

                    instanceRef.value = {
                        modal: modal,
                        close: (data) => {
                            modal.hide();
                            resolve(data);
                        },
                    };

                    modal.updateOnHide(() => {
                        app.unmount();
                        container.remove();
                    });
                }
            });
        })

        const app = createApp({
            render: () => h(options.component, options.props)
        });

        app.mount(container);

        return modalPromise;
    }

}

export default new ModalService();
