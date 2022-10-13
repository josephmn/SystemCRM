using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VDistrito : BDconexion
    {
        public List<EDistrito> Listar_Distrito(Int32 provincia)
        {
            List<EDistrito> lCDistrito = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CDistrito oVDistrito = new CDistrito();
                    lCDistrito = oVDistrito.Listar_Distrito(con, provincia);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCDistrito);
        }
    }
}