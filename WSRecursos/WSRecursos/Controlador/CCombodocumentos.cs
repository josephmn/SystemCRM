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
    public class CCombodocumentos
    {
        public List<ECombodocumentos> Listar_Combodocumentos(SqlConnection con, Int32 post, Int32 id, String dni)
        {
            List<ECombodocumentos> lECombodocumentos = null;
            SqlCommand cmd = new SqlCommand("ASP_CARGAR_DOCUMENTOS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;
            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lECombodocumentos = new List<ECombodocumentos>();

                ECombodocumentos obECombodocumentos = null;
                while (drd.Read())
                {
                    obECombodocumentos = new ECombodocumentos();
                    obECombodocumentos.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obECombodocumentos.v_nombre = drd["v_nombre"].ToString();
                    obECombodocumentos.v_carpeta = drd["v_carpeta"].ToString();
                    obECombodocumentos.v_modulo = drd["v_modulo"].ToString();
                    obECombodocumentos.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obECombodocumentos.v_estado = drd["v_estado"].ToString();
                    obECombodocumentos.v_color_estado = drd["v_color_estado"].ToString();
                    obECombodocumentos.v_type_archivo = drd["v_type_archivo"].ToString();
                    obECombodocumentos.i_cantidad = drd["i_cantidad"].ToString();
                    obECombodocumentos.v_cantidad = drd["v_cantidad"].ToString();
                    obECombodocumentos.v_color_cantidad = drd["v_color_cantidad"].ToString();
                    obECombodocumentos.f_size = Convert.ToDouble(drd["f_size"].ToString());
                    obECombodocumentos.d_fecha_actualiza = drd["d_fecha_actualiza"].ToString();
                    lECombodocumentos.Add(obECombodocumentos);
                }
                drd.Close();
            }

            return (lECombodocumentos);
        }
    }
}