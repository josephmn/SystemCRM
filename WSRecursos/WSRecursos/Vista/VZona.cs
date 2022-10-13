using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VZona : BDconexion
    {
        public List<EZona> Listar_Zona(Int32 id, Int32 zona)
        {
            List<EZona> lCZona = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CZona oVZona = new CZona();
                    lCZona = oVZona.Listar_Zona(con, id, zona);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCZona);
        }
    }
}