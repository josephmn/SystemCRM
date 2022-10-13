using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VTipoTrabajador : BDconexion
    {
        public List<ETipoTrabajador> TipoTrabajador()
        {
            List<ETipoTrabajador> lCTipoTrabajador = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CTipoTrabajador oVTipoTrabajador = new CTipoTrabajador();
                    lCTipoTrabajador = oVTipoTrabajador.Listar_TipoTrabajador(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCTipoTrabajador);
        }
    }
}