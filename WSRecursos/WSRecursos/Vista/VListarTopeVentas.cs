using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarTopeVentas : BDconexion
    {
        public List<EListarTopeVentas> ListarTopeVentas(String dni)
        {
            List<EListarTopeVentas> lCListarTopeVentas = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarTopeVentas oVListarTopeVentas = new CListarTopeVentas();
                    lCListarTopeVentas = oVListarTopeVentas.ListarTopeVentas(con, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarTopeVentas);
        }
    }
}