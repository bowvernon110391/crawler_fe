// icons to use
import {
    IdCard,
    Power,
    Archive,
    LockClosed,
    Search
} from '@vicons/ionicons5'


// our menu structure
const menus = [
    // simple item (Link)
    {
        "text": "About Page",
        "icon": IdCard,
        "href": "/about",
        "key": "/about",
    },
    {
        "text": "User Privacy",
        "icon": LockClosed,
        "url": "https://lmgtfy.app?q=shit+take",
        "key": "user-privacy",
        "role": [ "user" ]
    },
    {
        "text": "Browse",
        "icon": Search,
        "key": "browse",
        "children": [
            {
                "text": "Crawling Job",
                "key": "/jobs",
                "href": "/jobs",
                "icon": Power
            }
        ]
    },
    // a group, it had to point to base url of a resource, or something 
    // otherwise the auto expand menu won't work
    {
        "text": "Messages",
        "icon":Power,
        "key": "dummy",
        "role": ["user", "administrator"],
        "children": [
            {
                "text": "Info",
                "href": "/dummy/1",
                "key": "/dummy/1",
                "icon": Power,
            },
            {
                "text": "Warning",
                "icon": Power,
                "href": "/dummy/2",
                "key": "/dummy/2",
            },
            {
                "text": "Success",
                "icon": Power,
                "href": "/dummy/3",
                "key": "/dummy/3"
            },
            {
                "text": "Error",
                "icon": Power,
                "href": "/dummy/4",
                "key": "/dummy/4"
            }
        ]
    },
    // a link to external site
    {
        "text": "Secret Files",
        "icon": Archive,
        "url": "https://www.google.com?q=bokep",
        "key": "secret-files"
    }
]

export default menus