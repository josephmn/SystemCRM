using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CZona
    {
        public List<EZona> Listar_Zona(SqlConnection con, Int32 id, Int32 zona)
        {
            List<EZona> lEZona = null;
            SqlCommand cmd = new SqlCommand("ASP_ZONA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlParameter par1 = cmd.Parameters.Add("@id", SqlDbType.Int);
            par1.Direction = ParameterDirection.Input;
            par1.Value = id;

            SqlParameter par2 = cmd.Parameters.Add("@zona", SqlDbType.Int);
            par2.Direction = ParameterDirection.Input;
            par2.Value = zona;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEZona = new List<EZona>();

                EZona obEZona = null;
                while (drd.Read())
                {
                    obEZona = new EZona();
                    obEZona.i_codigo = drd["i_codigo"].ToString();
                    obEZona.v_descripcion = drd["v_descripcion"].ToString();
                    obEZona.i_estado = drd["i_estado"].ToString();
                    lEZona.Add(obEZona);
                }
                drd.Close();
            }

            return (lEZona);
        }
    }
}