const ACCORDION_CLASS_PREFIX = "";
const ACCORDION_ACTIVE_CLASS = ACCORDION_CLASS_PREFIX + "accordion-active";
const ACCORDION_MENU_CLASS_NAME = ACCORDION_CLASS_PREFIX + "accordion-menu";
const ACCORDION_MENU_ACTIVE_CLASS = ACCORDION_CLASS_PREFIX + "accordion-menu-active";

function init_accordion_tree(accordion_menu) {
    let accordion_elements = [];
    let item_to_deploy = [];

    let show_element = (element) => {
        if (~element.classList.contains(ACCORDION_ACTIVE_CLASS))
            element.classList.add(ACCORDION_ACTIVE_CLASS);

        if (element.accordion_children !== undefined)
            if (~element.accordion_children.classList.contains(ACCORDION_MENU_ACTIVE_CLASS))
                element.accordion_children.classList.add(ACCORDION_MENU_ACTIVE_CLASS);

        if (element.accordion_parent !== undefined)
            show_element(element.accordion_parent);
    };

    let hide_element = (element) => {
        if (element.classList.contains(ACCORDION_ACTIVE_CLASS))
            element.classList.remove(ACCORDION_ACTIVE_CLASS);

        if (element.accordion_children !== undefined) {
            if (element.accordion_children.classList.contains(ACCORDION_MENU_ACTIVE_CLASS))
                element.accordion_children.classList.remove(ACCORDION_MENU_ACTIVE_CLASS);

            hide_element(element.accordion_children);
        }
    }

    let switch_element = (element) => {
        if (element.classList.contains(ACCORDION_ACTIVE_CLASS))
            hide_element(element);
        else
            show_element(element);
    }

    let reference_children = (parent) => {
        let li_elts = [...parent.childNodes].filter(e => (e.nodeName.toLowerCase() === 'li'));

        parent.accordion_children = [li_elts];
        accordion_elements.push(parent);

        for(let i = 0; i < li_elts.length; i++) {
            accordion_elements.push(li_elts[i]);

            let a_elts = [...li_elts[i].childNodes].filter(e => (e.nodeName.toLowerCase() === 'a'));

            // If we detect that the element is activated by default, we will deploy it
            if(li_elts[i].classList.contains(ACCORDION_ACTIVE_CLASS))
                item_to_deploy.push(li_elts[i]);

            // Add event to deploy the tree
            if(a_elts.length >= 1) {
                a_elts[0].addEventListener("click", function() {
                    switch_element(li_elts[i]);
                });
            }

            // Add next level to the tree
            let ul_elts = [...li_elts[i].childNodes].filter(
                e => (e.nodeName.toLowerCase() === 'ul' && e.classList.contains(ACCORDION_MENU_CLASS_NAME))
            );

            if (ul_elts.length >= 1) {
                // Reference parents and children inside the element
                li_elts[i].accordion_children = ul_elts[0];
                li_elts[i].accordion_parent = parent;
                ul_elts[0].accordion_parent = li_elts[i];

                // If the <li> element contains multiple level, we apply a special class which will identify it
                li_elts[i].classList.add(ACCORDION_CLASS_PREFIX + "accordion-dropdown");

                // Recursive call to reference children of the <li> element
                reference_children(ul_elts[0]);
            }
            else if (ul_elts.length > 1) console.error('Multiple levels detected');
            else li_elts[i].accordion_children = undefined;
        }
    };

    // Define "accordion_menu" as root
    accordion_menu.accordion_parent = undefined;
    reference_children(accordion_menu);

    // Show pre-selected elements
    for(let i = 0; i < item_to_deploy.length; i++)
        show_element(item_to_deploy[i]);
}


