[
    {
        "name": "id",
        "dbType": "increments",
        "htmlType": "",
        "validations": "",
        "searchable": false,
        "fillable": false,
        "primary": true,
        "inForm": false,
        "inIndex": false,
        "inView": false
    },
    {
        "name": "device_id",
        "dbType": "integer:unsigned:foreign,devices,id",
        "htmlType": "number",
        "validations": "required",
        "searchable": true,
        "inIndex": true,
        "relation": "mt1,Device,device_id,id"
    },
    {
        "name": "data_variable_id",
        "dbType": "integer:unsigned:foreign,data_variables,id",
        "htmlType": "number",
        "validations": "required",
        "searchable": true,
        "inIndex": true,
        "relation": "mt1,DataVariable,data_variable_id,id"
    },
    {
        "name": "created_at",
        "dbType": "timestamp",
        "htmlType": "",
        "validations": "",
        "searchable": false,
        "fillable": false,
        "primary": false,
        "inForm": false,
        "inIndex": false
    },
    {
        "name": "updated_at",
        "dbType": "timestamp",
        "htmlType": "",
        "validations": "",
        "searchable": false,
        "fillable": false,
        "primary": false,
        "inForm": false,
        "inIndex": false
    }     
]