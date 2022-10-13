using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarvacacionesxdni : BDconexion
    {
        public List<EListarvacacionesxdni> Listar_Listarvacacionesxdni(String dni)
        {
            List<EListarvacacionesxdni> lCListarvacacionesxdni = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarvacacionesxdni oVListarvacacionesxdni = new CListarvacacionesxdni();
                    lCListarvacacionesxdni = oVListarvacacionesxdni.Listar_Listarvacacionesxdni(con, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarvacacionesxdni);
        }
    }
}