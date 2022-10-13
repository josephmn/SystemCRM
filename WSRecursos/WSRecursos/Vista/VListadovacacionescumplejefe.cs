using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListadovacacionescumplejefe : BDconexion
    {
        public List<EListadovacacionescumplejefe> Listadovacacionescumplejefe(String dni, String finicio, String ffin)
        {
            List<EListadovacacionescumplejefe> lCListadovacacionescumplejefe = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListadovacacionescumplejefe oVListadovacacionescumplejefe = new CListadovacacionescumplejefe();
                    lCListadovacacionescumplejefe = oVListadovacacionescumplejefe.Listadovacacionescumplejefe(con, dni, finicio, ffin);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListadovacacionescumplejefe);
        }
    }
}