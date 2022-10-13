using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListadocontrolvacacionesjefe : BDconexion
    {
        public List<EListadocontrolvacacionesjefe> Listar_Listadocontrolvacacionesjefe(String dni, String finicio, String ffin)
        {
            List<EListadocontrolvacacionesjefe> lCListadocontrolvacacionesjefe = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListadocontrolvacacionesjefe oVListadocontrolvacacionesjefe = new CListadocontrolvacacionesjefe();
                    lCListadocontrolvacacionesjefe = oVListadocontrolvacacionesjefe.Listar_Listadocontrolvacacionesjefe(con, dni, finicio, ffin);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListadocontrolvacacionesjefe);
        }
    }
}